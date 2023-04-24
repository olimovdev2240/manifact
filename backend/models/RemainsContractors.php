<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "remains_contractors".
 *
 * @property int $id
 * @property int $contractor_id Kontragent
 * @property string|null $comment Izoh
 * @property float|null $cost_sum So`mdagi summa
 * @property float|null $cost_usd Dollardagi summa
 * @property int $nodebt Xaqdorlik
 * @property string|null $date Sana
 * @property float $current_rate Kurs
 * @property int $user_id
 * @property string|null $special
 */
class RemainsContractors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remains_contractors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contractor_id', 'current_rate', 'user_id'], 'required'],
            [['contractor_id', 'nodebt', 'user_id'], 'integer'],
            [['comment'], 'string'],
            [['cost_sum', 'cost_usd', 'current_rate'], 'number'],
            [['date'], 'safe'],
            [['special'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contractor_id' => Yii::t('app', 'Kontragent'),
            'comment' => Yii::t('app', 'Izoh'),
            'cost_sum' => Yii::t('app', 'So`mdagi summa'),
            'cost_usd' => Yii::t('app', 'Dollardagi summa'),
            'nodebt' => Yii::t('app', 'Xaqdorlik'),
            'date' => Yii::t('app', 'Sana'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'user_id' => Yii::t('app', 'User ID'),
            'special' => Yii::t('app', 'Special'),
        ];
    }
    //qoldiqlarni yuklash
    public static function getAdditionalAttributes($id){
        $sql = "SELECT rc.id id, contractor_id, c.name contractor, rc.date date, rc.comment comment, rc.cost_sum cost_sum, rc.cost_usd cost_usd, rc.nodebt nodebt FROM remains_contractors rc
        LEFT JOIN contractors c 
        ON c.id = rc.contractor_id
        WHERE rc.contractor_id = {$id}";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        return $data;
    }
}
