<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "exchange_rates".
 *
 * @property int $id
 * @property float $rate Kurs
 * @property string|null $date Sanasi
 */
class ExchangeRates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exchange_rates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate'], 'required'],
            [['rate'], 'number'],
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
            'rate' => Yii::t('app', 'Kurs'),
            'date' => Yii::t('app', 'Sanasi'),
        ];
    }
    public static function getRateByDate($date){
        $rate = self::find()
        ->where(['<=', 'date', $date])
        ->orderBy(['id'=>SORT_DESC])
        ->one();
        return $rate->rate;
    }
}
