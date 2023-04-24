<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "report_salary".
 *
 * @property int $id
 * @property int $cost_id Xarajat
 * @property int $worker_id Ishchi
 * @property string $comment Izoh
 * @property float $cost_sum So`mdagi summa
 * @property float $cost_usd Valyutadagi summa
 *
 * @property Costs $cost
 */
class ReportSalary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cost_id', 'worker_id', 'cost_sum', 'cost_usd'], 'required'],
            [['cost_id', 'worker_id'], 'integer'],
            [['comment'], 'string'],
            [['cost_sum', 'cost_usd'], 'number'],
            [['cost_id'], 'exist', 'skipOnError' => true, 'targetClass' => Costs::className(), 'targetAttribute' => ['cost_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cost_id' => Yii::t('app', 'Xarajat'),
            'worker_id' => Yii::t('app', 'Ishchi'),
            'comment' => Yii::t('app', 'Izoh'),
            'cost_sum' => Yii::t('app', 'So`mdagi summa'),
            'cost_usd' => Yii::t('app', 'Valyutadagi summa'),
        ];
    }

    /**
     * Gets query for [[Cost]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCost()
    {
        return $this->hasOne(Costs::className(), ['id' => 'cost_id']);
    }
    public static function saveWithOld($id){
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        // exit();
        //eski attributlarni hisobga olib saqlash
        $old = Yii::$app->db->createCommand("SELECT *FROM report_salary where id ={$id}")->queryOne();
        $cost = Costs::findOne($old['cost_id']);
        $cost->remains_sum += $old['cost_sum']; 
        $cost->remains_usd += $old['cost_usd'];
        $cost->cost_sum -= $old['cost_sum']; 
        $cost->cost_usd -= $old['cost_usd'];
        $cost->save();
        $office = PayOffices::findOne($cost->office_id);
        $office->remains_sum += $old['cost_sum']; 
        $office->remains_usd += $old['cost_usd'];
        $office->save();
    }
}
