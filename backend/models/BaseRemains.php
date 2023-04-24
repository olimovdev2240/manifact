<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_remains".
 *
 * @property int $id
 * @property int $base_id Ombor
 * @property int $product_id Maxsulot
 * @property float $qty Soni
 */
class BaseRemains extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_remains';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base_id', 'product_id'], 'required'],
            [['base_id', 'product_id'], 'integer'],
            [['qty'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'base_id' => Yii::t('app', 'Ombor'),
            'product_id' => Yii::t('app', 'Maxsulot'),
            'qty' => Yii::t('app', 'Soni'),
        ];
    }
    //qoldiqlarni qo`shish ketish
    public static function addQty($base, $product, $qty){
        $model = self::find()
        ->andWhere(['base_id'=>$base])
        ->andWhere(['product_id'=>$product])
        ->one();
        if(empty($model)){
            $model = new BaseRemains();
            $model->product_id = $product;
            $model->base_id = $base;
            $model->qty = $qty;
            if($model->save())return true;
            return false;
        }else{
            $model->qty += $qty;
            if($model->save())return true;
            return false;
        }
    }
    //qoldiqlarni ayrib ketish
    public static function removeQty($base, $product, $qty){
        $model = self::find()
        ->andWhere(['base_id'=>$base])
        ->andWhere(['product_id'=>$product])
        ->one();
        if(empty($model)){
            $model = new BaseRemains();
            $model->product_id = $product;
            $model->base_id = $base;
            $model->qty = -$qty;
            if($model->save())return true;
            return false;
        }else{
            $model->qty -= $qty;
            if($model->save())return true;
            return false;
        }
    }
    //invga qoldiqlarni base boyicha jo`natish
    public static function getProductsByBase($id){
        if($id=="") return false;
        $sql = "
        SELECT p.name pname, br.product_id product_id, br.qty remains FROM base_remains br
        LEFT JOIN products p
        ON p.id = br.product_id
        WHERE base_id = {$id}
        ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    //invga qoldiqlarni group boyicha jo`natish
    public static function getProductsByGroup($id, $base){
        if($id=="" || $base=="") return false;
        $sql = "
        SELECT p.name pname, br.product_id product_id, br.qty remains FROM base_remains br
        LEFT JOIN products p
        ON p.id = br.product_id
        WHERE br.product_id IN  (SELECT id FROM products WHERE group_id = {$id})
        AND base_id = {$base}
        ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    public static function setRemains($item, $base){
        $model = self::findOne(['base_id'=>$base, 'product_id'=>$item['product_id']]);
        $model->qty -= $item['few'] - $item['much'];
        if($model->save()) return true;
        else return false; 
    }
    public static function unsetRemains($item, $base){
        $model = self::findOne(['base_id'=>$base, 'product_id'=>$item['product_id']]);
        $model->qty += $item['few'] - $item['much'];
        if($model->save()) return true;
        else return false; 
    }
}
