<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "office_to_office".
 *
 * @property int $id
 * @property int $debit_office Kirim kassa
 * @property int $outlay_office Chiqim kassa
 * @property float $amount Summa
 * @property int $exchange Valyuta
 * @property float $current_rate Kurs
 * @property float|null $exchange_sum Konvertatsiya summasi
 * @property string|null $comment Izoh
 * @property string|null $date Sana
 * @property int $user_id Foydalanuvchi
 */
class OfficeToOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'office_to_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['debit_office', 'outlay_office', 'amount', 'current_rate', 'user_id'], 'required'],
            [['debit_office', 'outlay_office', 'exchange', 'user_id'], 'integer'],
            [['amount', 'current_rate', 'exchange_sum'], 'number'],
            [['comment'], 'string'],
            [['debit_office'], 'exist', 'skipOnError' => true, 'targetClass' => PayOffices::className(), 'targetAttribute' => ['debit_office' => 'id']],
            [['outlay_office'], 'exist', 'skipOnError' => true, 'targetClass' => PayOffices::className(), 'targetAttribute' => ['outlay_office' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'debit_office' => Yii::t('app', 'Kirim kassa'),
            'outlay_office' => Yii::t('app', 'Chiqim kassa'),
            'amount' => Yii::t('app', 'Summa'),
            'exchange' => Yii::t('app', 'Valyuta'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'exchange_sum' => Yii::t('app', 'Konvertatsiya summasi'),
            'comment' => Yii::t('app', 'Izoh'),
            'date' => Yii::t('app', 'Sana'),
            'user_id' => Yii::t('app', 'Foydalanuvchi'),
        ];
    }
    public function getDebit()
    {
        return $this->hasOne(PayOffices::className(), ['id' => 'debit_office']);
    }
    public function getOutlay()
    {
        return $this->hasOne(PayOffices::className(), ['id' => 'outlay_office']);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
}
