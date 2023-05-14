<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "exchanges".
 *
 * @property int $id
 * @property string $name Nomi
 * @property string $little_name Qisqartma nomi
 * @property int $rate Kursi
 *
 * @property PayOffices[] $payOffices
 * @property PricesType[] $pricesTypes
 */
class Exchanges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exchanges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'little_name', 'rate'], 'required'],
            [['rate'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['little_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nomi'),
            'little_name' => Yii::t('app', 'Qisqartma nomi'),
            'rate' => Yii::t('app', 'Kursi'),
        ];
    }

    /**
     * Gets query for [[PayOffices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayOffices()
    {
        return $this->hasMany(PayOffices::className(), ['exchange' => 'id']);
    }

    /**
     * Gets query for [[PricesTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPricesTypes()
    {
        return $this->hasMany(PricesType::className(), ['amount_exchange' => 'id']);
    }
}
