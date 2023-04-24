<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Range form
 */
class RangeForm extends Model
{
    public $from;
    public $to;
    public $date_range;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to'], 'safe'],
            ['date_range', 'required']
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'from' => Yii::t('app', 'dan'),
            'to' => Yii::t('app', 'gacha'),
            'date_range' => Yii::t('app', 'Sana oralig`i'),
        ];
    }
}
