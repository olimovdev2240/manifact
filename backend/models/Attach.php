<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "attach".
 *
 * @property int $id
 * @property int $product_id Yarimtayyor maxsulot
 * @property int $invertor_id Ishlatiladigan mahsulot
 * @property int $qty Miqdori
 */
class Attach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'invertor_id', 'qty'], 'required'],
            [['product_id', 'invertor_id', 'qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Yarimtayyor maxsulot'),
            'invertor_id' => Yii::t('app', 'Ishlatiladigan mahsulot'),
            'qty' => Yii::t('app', 'Miqdori'),
        ];
    }
}
