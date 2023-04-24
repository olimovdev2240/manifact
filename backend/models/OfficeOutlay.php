<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "office_outlay".
 *
 * @property int $id
 * @property int $user_id Foydalanuvchi
 * @property int $office_id Kirim kassasi
 * @property int $contractor_id Kontragent
 * @property float $amount Summa
 * @property int $exchange Valyuta
 * @property string $comment Izoh
 * @property float $current_rate Kurs
 * @property string|null $date Sana
 * @property float|null $exchange_sum Konvertatsiya summasi
 */
class OfficeOutlay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'office_outlay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'office_id', 'contractor_id', 'amount', 'current_rate'], 'required'],
            [['user_id', 'office_id', 'contractor_id', 'exchange'], 'integer'],
            [['amount', 'current_rate', 'exchange_sum'], 'number'],
            [['comment'], 'string'],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayOffices::className(), 'targetAttribute' => ['office_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contractors::className(), 'targetAttribute' => ['contractor_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['date', 'comment'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Foydalanuvchi'),
            'office_id' => Yii::t('app', 'Chiqim kassasi'),
            'contractor_id' => Yii::t('app', 'Kontragent'),
            'amount' => Yii::t('app', 'Summa'),
            'exchange' => Yii::t('app', 'Valyuta'),
            'comment' => Yii::t('app', 'Izoh'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'date' => Yii::t('app', 'Sana'),
            'exchange_sum' => Yii::t('app', 'Konvertatsiya summasi'),
        ];
    }
    public function getOffice()
    {
        return $this->hasOne(PayOffices::className(), ['id' => 'office_id']);
    }
    public function getContractor()
    {
        return $this->hasOne(Contractors::className(), ['id' => 'contractor_id']);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
}
