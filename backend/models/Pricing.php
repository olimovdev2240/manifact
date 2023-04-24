<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pricing".
 *
 * @property int $id
 * @property int $product_id Maxsulot
 * @property int $stage_id Etap
 * @property float $amout Narx
 * @property float|null $goal Maksimum miqdor
 */
class Pricing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'stage_id', 'amout'], 'required'],
            [['product_id', 'stage_id'], 'integer'],
            [['amout', 'goal'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Maxsulot'),
            'stage_id' => Yii::t('app', 'Etap'),
            'amout' => Yii::t('app', 'Narx'),
            'goal' => Yii::t('app', 'Maksimum miqdor'),
        ];
    }
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }
    public function getStage()
    {
        return $this->hasOne(Stages::class, ['id' => 'stage_id']);
    }
}
