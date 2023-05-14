<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pay_offices".
 *
 * @property int $id
 * @property string|null $code Kodi
 * @property string $name Nomi
 * @property float $remains_sum So`mdagi qoldiq
 * @property float $remains_usd Valyutadagi qoldiq
 * @property int $bank Bankdami?
 * @property int $section_id Bo`lim
 * @property int|null $exchange Valyuta turi
 * @property int $status Status
 *
 * @property Exchanges $exchange0
 * @property Sections $section
 */
class PayOffices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_offices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'section_id'], 'required'],
            [['remains_sum', 'remains_usd'], 'number'],
            [['bank', 'section_id', 'exchange', 'status', 'user_id'], 'integer'],
            [['code', 'name'], 'string', 'max' => 255],
            [['exchange'], 'exist', 'skipOnError' => true, 'targetClass' => Exchanges::className(), 'targetAttribute' => ['exchange' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sections::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Kassir'),
            'code' => Yii::t('app', 'Kodi'),
            'name' => Yii::t('app', 'Nomi'),
            'remains_sum' => Yii::t('app', 'So`mdagi qoldiq'),
            'remains_usd' => Yii::t('app', 'Valyutadagi qoldiq'),
            'bank' => Yii::t('app', 'Bankdami?'),
            'section_id' => Yii::t('app', 'Bo`lim'),
            'exchange' => Yii::t('app', 'Valyuta turi'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Exchange0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExchange0()
    {
        return $this->hasOne(Exchanges::className(), ['id' => 'exchange']);
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Sections::className(), ['id' => 'section_id']);
    }
    //Qoldiqlar qoshib ketiladi
    public static function addRemains($o){
        $office = self::findOne($o['office_id']);
        $office->remains_sum += $o['cost_sum'];
        $office->remains_usd += $o['cost_usd'];
        if($office->save()) return true;
        return false;
    }
    //Qoldiqlar ayrib ketiladi
    public static function removeRemains($o){
        $office = self::findOne($o['office_id']);
        $office->remains_sum -= $o['cost_sum'];
        $office->remains_usd -= $o['cost_usd'];
        if($office->save()) return true;
        return false;
    }
}
