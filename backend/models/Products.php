<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name_uz Nomi (Lotincha)
 * @property string $name_ru Nomi (Krillcha)
 * @property int $type_id Turi
 * @property int $volume_id Birligi
 * @property int $notif Xabarnoma
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'type_id', 'volume_id'], 'required'],
            [['type_id', 'volume_id', 'notif'], 'integer'],
            [['name_uz', 'name_ru'], 'string', 'max' => 255],
            [['volume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Volumes::className(), 'targetAttribute' => ['volume_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_uz' => Yii::t('app', 'Nomi (Lotincha)'),
            'name_ru' => Yii::t('app', 'Nomi (Krillcha)'),
            'type_id' => Yii::t('app', 'Turi'),
            'volume_id' => Yii::t('app', 'Birligi'),
            'notif' => Yii::t('app', 'Xabarnoma'),
        ];
    }
    public function getVolume()
    {
        return $this->hasOne(Volumes::className(), ['id' => 'volume_id']);
    }
    public static function getProductsForDoc()
    {
        $sql = "SELECT br.qty remains, p.name_uz product, fee.fee_arg fee, br.base_id base
        FROM ( SELECT concat('pid', bri.product_id, 'bid', bri.base_id) spb, bri.qty qty, bri.product_id product_id, bri.base_id base_id FROM base_remains bri ) br
                LEFT JOIN products p
                ON p.id = br.product_id
                LEFT JOIN (SELECT concat('pid', product_id, 'bid', base_id) spi, income.*, income.price fee_arg FROM base_income income  GROUP BY spi) fee
                ON fee.spi = br.spb";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }
}
