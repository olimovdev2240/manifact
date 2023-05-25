<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "attached".
 *
 * @property int $id
 * @property int|null $product Chiqarilgan maxsulot
 * @property int|null $material Ishlatilgan material
 * @property float|null $qty Miqdori
 * @property float|null $price Narxi
 * @property string|null $date Sanasi
 */
class Attached extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attached';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'material'], 'integer'],
            [['qty', 'price'], 'number'],
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
            'product' => Yii::t('app', 'Chiqarilgan maxsulot'),
            'material' => Yii::t('app', 'Ishlatilgan material'),
            'qty' => Yii::t('app', 'Miqdori'),
            'price' => Yii::t('app', 'Narxi'),
            'date' => Yii::t('app', 'Sanasi'),
        ];
    }
}
