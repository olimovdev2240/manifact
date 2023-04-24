<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "costs".
 *
 * @property int $id
 * @property int $office_id Kassa
 * @property int $user_id Hodim
 * @property float $remains_sum So`mdagi qoldiq
 * @property float $cost_sum So`mdagi xarajat
 * @property float $remains_usd Valyutadagi qoldiq
 * @property float $cost_usd Valyutadagi xarajat
 * @property string $date Sanasi
 * @property int $current_rate
 * @property string $expense Xarajatlar
 *
 * @property PayOffices $office
 * @property ReportSalary[] $reportSalaries
 * @property SalaryReport[] $salaryReports
 */
class Costs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'costs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['office_id',  'user_id', 'cost_usd', 'current_rate'], 'required'],
            [['office_id',  'user_id', 'current_rate'], 'integer'],
            [['remains_sum', 'cost_sum', 'remains_usd', 'cost_usd'], 'number'],
            [['date'], 'safe'],
            [['salary', 'expense'], 'string', 'max' => 255],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayOffices::className(), 'targetAttribute' => ['office_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'office_id' => Yii::t('app', 'Kassa'),
            'user_id' => Yii::t('app', 'Hodim'),
            'remains_sum' => Yii::t('app', 'Qoldiq s'),
            'cost_sum' => Yii::t('app', 'Xarajat s'),
            'remains_usd' => Yii::t('app', 'Qoldiq $'),
            'cost_usd' => Yii::t('app', 'Xarajat $'),
            'date' => Yii::t('app', 'Sanasi'),
            'current_rate' => Yii::t('app', 'Current Rate'),
            'salary' => Yii::t('app', 'Ish haqiga'),
            'expense' => Yii::t('app', 'Xarajatlar'),
        ];
    }

    /**
     * Gets query for [[Office]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(PayOffices::className(), ['id' => 'office_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public static function getAdditionalAttributes($id){
        $salaries = Yii::$app->db->createCommand("
            SELECT rs.id id, worker_id, w.full_name worker, comment, cost_sum, cost_usd FROM report_salary rs
            LEFT JOIN workers w 
            ON w.id = rs.worker_id
            WHERE cost_id = {$id} 
        ")->queryAll();
        $attr = [
            'salary'=>$salaries,
        ];        
        return $attr;
    }
}
