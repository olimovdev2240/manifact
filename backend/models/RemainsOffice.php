<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "remains_office".
 *
 * @property int $id
 * @property int $office_id Kassa
 * @property string|null $comment Izoh
 * @property float|null $cost_sum So`mdagi qoldiq
 * @property float|null $cost_usd Valyutadagi qoldiq
 * @property string|null $date Sana
 * @property float $current_rate Kurs
 * @property int $user_id Foydalanuvchi
 * @property string|null $special
 */
class RemainsOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remains_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['office_id', 'current_rate', 'user_id'], 'required'],
            [['office_id', 'user_id'], 'integer'],
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
            'office_id' => Yii::t('app', 'Kassa'),
            'comment' => Yii::t('app', 'Izoh'),
            'cost_sum' => Yii::t('app', 'So`mdagi qoldiq'),
            'cost_usd' => Yii::t('app', 'Valyutadagi qoldiq'),
            'date' => Yii::t('app', 'Sana'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'user_id' => Yii::t('app', 'Foydalanuvchi'),
            'special' => Yii::t('app', 'Special'),
        ];
    }
    //qoldiqlarni yuklash
    public static function getAdditionalAttributes($id){
        $sql = "SELECT ro.id id, office_id, o.name office, ro.date date, ro.comment comment, ro.cost_sum cost_sum, ro.cost_usd cost_usd FROM remains_office ro
        LEFT JOIN pay_offices o 
        ON o.id = ro.office_id
        WHERE ro.office_id = {$id}";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        return $data;
    }
}
