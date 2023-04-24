<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pi_items".
 *
 * @property int $id
 * @property int $pi_id
 * @property int $product_id Maxsulot
 * @property string $volume Birlik
 * @property float $qty Miqdor
 * @property float $price Narx
 * @property float $amount Summa
 * @property int $exchange Valyuta
 */
class PiItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pi_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pi_id', 'product_id', 'volume', 'qty', 'price', 'amount'], 'required'],
            [['pi_id', 'product_id', 'exchange'], 'integer'],
            [['qty', 'price', 'amount'], 'number'],
            [['volume'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pi_id' => Yii::t('app', 'Pi ID'),
            'product_id' => Yii::t('app', 'Maxsulot'),
            'volume' => Yii::t('app', 'Birlik'),
            'qty' => Yii::t('app', 'Miqdor'),
            'price' => Yii::t('app', 'Narx'),
            'amount' => Yii::t('app', 'Summa'),
            'exchange' => Yii::t('app', 'Valyuta'),
        ];
    }
}
