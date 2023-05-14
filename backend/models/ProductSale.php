<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_sale".
 *
 * @property int $id
 * @property int $user_id Foydalanuvchi
 * @property int $base_id Ombor
 * @property int $contractor_id Xaridor
 * @property int $office_id Kassa
 * @property float $amount Tovarlar summasi
 * @property float $exchange_amount Valyuta turi
 * @property int $convertme Konvertatsiya
 * @property float|null $amount_convert Konv. summasi
 * @property float $current_rate Kurs
 * @property string|null $date Sana
 *
 * @property PsProducts[] $psProducts
 * @property PsServices[] $psServices
 */
class ProductSale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'contractor_id', 'office_id', 'amount', 'exchange_amount', 'current_rate'], 'required'],
            [['user_id', 'base_id', 'contractor_id', 'office_id', 'convertme'], 'integer'],
            [['amount', 'exchange_amount', 'amount_convert', 'current_rate'], 'number'],
            [['date'], 'safe'],
            [['products', 'services'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Jo`natuvchi'),
            'base_id' => Yii::t('app', 'Ombor'),
            'contractor_id' => Yii::t('app', 'Xaridor'),
            'office_id' => Yii::t('app', 'Kassa'),
            'amount' => Yii::t('app', 'Tovarlar summasi'),
            'exchange_amount' => Yii::t('app', 'Valyuta turi'),
            'convertme' => Yii::t('app', 'Konvertatsiya'),
            'amount_convert' => Yii::t('app', 'Kassaga tushadigan summa'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'date' => Yii::t('app', 'Sana'),
            'products' => Yii::t('app', 'Products'),
            'services' => Yii::t('app', 'Services'),
        ];
    }

    /**
     * Gets query for [[PsProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPsProducts()
    {
        return $this->hasMany(PsProducts::className(), ['ps_id' => 'id']);
    }

    /**
     * Gets query for [[PsServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPsServices()
    {
        return $this->hasMany(PsServices::className(), ['ps_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getContractor()
    {
        return $this->hasOne(Contractors::className(), ['id' => 'contractor_id']);
    }
    public function getBase()
    {
        return $this->hasOne(Bases::className(), ['id' => 'base_id']);
    }
    public function getOffice()
    {
        return $this->hasOne(PayOffices::className(), ['id' => 'office_id']);
    }
    public static function getProductAttributes($id, $base){
        $sql = "
        SELECT v.name volume, br.qty special, p.sale_price fee FROM products p 
            LEFT JOIN volumes v
            ON p.volume_id = v.id
            LEFT JOIN (SELECT qty, product_id FROM base_remains WHERE product_id={$id} AND base_id = {$base}) br
            ON br.product_id = p.id 
            WHERE p.id = {$id}
        ";
        return Yii::$app->db->createCommand($sql)->queryOne();
    }
    public static function getSaledProducts($id){
        $sql = "SELECT p.name_uz product, psp.product_id pid, psp.id id, psp.volume volume, psp.exchange exchange, psp.qty qty, psp.price price, psp.amount amount, psp.fee fee, psp.special special FROM ps_products psp
        LEFT JOIN products p
        ON p.id = psp.product_id
        WHERE psp.ps_id = {$id}
        
        ";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }
    public static function getSaledServices($id){
        $sql = "SELECT pss.id id, w.full_name worker, s.name service, pss.amount amount, pss.comment comment FROM ps_services pss
        LEFT JOIN services s 
        ON s.id = pss.service_id
        LEFT JOIN workers w
        ON w.id = pss.worker_id
        WHERE pss.ps_id = {$id}
        
        ";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }
}
