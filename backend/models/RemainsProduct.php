<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "remains_product".
 *
 * @property int $id
 * @property int $product_id Maxsulot
 * @property int $base_id Ombor
 * @property string|null $comment Izoh
 * @property float $qty Miqdori
 * @property float $price Narx
 * @property int $exchange Valyuta
 * @property float $amount Summa
 * @property float $current_rate Kurs
 * @property string|null $date Sana
 * @property int $user_id Foydalanuvchi
 */
class RemainsProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remains_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'base_id', 'qty', 'price', 'amount', 'current_rate', 'user_id'], 'required'],
            [['product_id', 'base_id', 'exchange', 'user_id'], 'integer'],
            [['comment'], 'string'],
            [['qty', 'price', 'amount', 'current_rate'], 'number'],
            [['date'], 'safe'],
            [['special'], 'string', 'max' => 255],
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
            'base_id' => Yii::t('app', 'Ombor'),
            'comment' => Yii::t('app', 'Izoh'),
            'qty' => Yii::t('app', 'Miqdori'),
            'price' => Yii::t('app', 'Narx'),
            'exchange' => Yii::t('app', 'Valyuta'),
            'amount' => Yii::t('app', 'Summa'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'date' => Yii::t('app', 'Sana'),
            'user_id' => Yii::t('app', 'Foydalanuvchi'),
            'special' => Yii::t('app', 'Special'),
        ];
    }
    //qoldiqlarni yuklash
    public static function getAdditionalAttributes($id){
        $sql = "SELECT rp.id id, product_id, p.name product, rp.date date, rp.comment comment, qty, price, exchange, amount FROM remains_product rp
        LEFT JOIN products p 
        ON p.id = rp.product_id
        WHERE rp.base_id = {$id}";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        return $data;
    }
}
