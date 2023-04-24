<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ps_products".
 *
 * @property int $id
 * @property int $ps_id
 * @property int $product_id Maxsulot
 * @property string|null $volume Birlik
 * @property int|null $exchange Valyuta
 * @property float|null $qty Miqdor
 * @property float|null $price Narx
 * @property float|null $amount Summa
 * @property float|null $fee Tannarx
 * @property string|null $special
 *
 * @property ProductSale $ps
 */
class PsProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ps_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ps_id', 'product_id'], 'required'],
            [['ps_id', 'product_id', 'exchange'], 'integer'],
            [['qty', 'price', 'amount', 'fee'], 'number'],
            [['special'], 'string'],
            [['volume'], 'string', 'max' => 255],
            [['ps_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSale::className(), 'targetAttribute' => ['ps_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ps_id' => Yii::t('app', 'Ps ID'),
            'product_id' => Yii::t('app', 'Maxsulot'),
            'volume' => Yii::t('app', 'Birlik'),
            'exchange' => Yii::t('app', 'Valyuta'),
            'qty' => Yii::t('app', 'Miqdor'),
            'price' => Yii::t('app', 'Narx'),
            'amount' => Yii::t('app', 'Summa'),
            'fee' => Yii::t('app', 'Tannarx'),
            'special' => Yii::t('app', 'Special'),
        ];
    }

    /**
     * Gets query for [[Ps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPs()
    {
        return $this->hasOne(ProductSale::className(), ['id' => 'ps_id']);
    }
}
