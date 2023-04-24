<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "base_income".
 *
 * @property int $id
 * @property int $product_id Maxsulot
 * @property int $base_id Ombor
 * @property float $qty Miqdor
 * @property float $remains_qty Qoldiq
 * @property float $price Narx
 * @property float $amount Summas
 * @property int|null $current_rate Kurs
 * @property int $exchange Valyuta
 * @property string|null $date Sana
 * @property int|null $remains_id qoldiq orqalimi?
 * @property int|null $income_id Tovar kirimidanmi?
 * 
 */
class BaseIncome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_income';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'base_id'], 'required'],
            [['product_id', 'base_id', 'current_rate', 'exchange', 'remains_id', 'income_id', 'contractor_id'], 'integer'],
            [['qty', 'remains_qty', 'price'], 'number'],
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
            'qty' => Yii::t('app', 'Miqdor'),
            'remains_qty' => Yii::t('app', 'Qoldiq'),
            'price' => Yii::t('app', 'Narx'),
            'amount' => Yii::t('app', 'Summas'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'exchange' => Yii::t('app', 'Valyuta'),
            'date' => Yii::t('app', 'Sana'),
            'special' => Yii::t('app', 'Maxsus'),
            'remains_id' => Yii::t('app', 'qoldiq orqalimi?'),
        ];
    }
    //Qoldiqlar qoshib ketiladi
    public static function addRemains($p)
    {
        $income = new BaseIncome();
        $income->base_id = $p->base_id;
        $income->product_id = $p->product_id;
        $income->qty = $p->qty;
        $income->remains_qty = $p->qty;
        $income->price = $p->price;
        $income->amount = $p->amount;
        $income->current_rate = $p->current_rate;
        $income->exchange = $p->exchange;
        $income->date = $p->date;
        $income->remains_id = $p->id;
        // echo "<pre>";
        // print_r($p);
        // echo "</pre>";
        // exit();
        if ($income->save()) return true;
        return false;
    }
    public static function addRemainsFromProduction($base_id, $product_id, $qty, $price)
    {
        $income = new BaseIncome();
        $income->base_id = $base_id;
        $income->product_id = $product_id;
        $income->qty = $qty;
        $income->remains_qty = $qty;
        $income->price = $price;
        $income->amount = $price * $qty;
        // echo "<pre>";
        // print_r($p);
        // echo "</pre>";
        // exit();
        if ($income->save()) return true;
        return false;
    }
    //update va delete uchun olib tashlash !remainsda
    public static function deleteRemains($id, $p)
    {
        $income = self::find()->where(['remains_id' => $id])->one();
        // echo "<pre>";
        // print_r($income);
        // echo "</pre>";
        // exit();
        if ($income->qty == $income->remains_qty) {
            if ($income->delete()) return true;
            return false;
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Ushbu amalni bajarish mumkin emas. Bu qoldiqdan sotuv qilingan!'));
            return false;
        }
    }
    public static function removeQtyByFIFO($base, $product, $qty)
    {
        $model = self::find()->where(['base_id' => $base, 'product_id' => $product])->andWhere(['>', 'remains_qty', 0])->orderBy(['date' => SORT_ASC])->all();
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        // exit();
        if (empty($model)) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Bazada hali bu maxsulot mavjud emas'));
            return false;
        }
        foreach ($model as $p) :
            if ($p->remains_qty >= $qty) {
                $p->remains_qty -= $qty;
                $p->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Jarayon muvaffaqiyatli tugatildi!'));
                return true;
            }
            $qty -= $p->remains_qty;
            $p->remains_qty = 0;
            $p->save();
            Yii::$app->session->setFlash('info', $p->id . Yii::t('app', ' id lik kirim tugatildi!'));
        endforeach;
    }
    public static function addQtyByFIFO($base, $product, $qty)
    {
        $model = self::find()->andWhere(['<>', 'remains_qty', 'qty'])->andWhere(['base_id' => $base, 'product_id' => $product])->orderBy(['date' => SORT_DESC])->all();
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        // exit();
        foreach ($model as $p) :
            if ($p->qty >= $qty) {
                $p->remains_qty += $qty;
                $p->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Jarayon muvaffaqiyatli tugatildi!'));
                return true;
            }
            $qty -= $p->qty;
            $p->remains_qty = $p->qty;
            $p->save();
            Yii::$app->session->setFlash('info', $p->id . Yii::t('app', ' id lik kirim tugatildi!'));
        endforeach;
    }
    public static function addIncome($id, $base, $product, $qty, $price, $amount, $current_rate, $date, $contractor)
    {
        $income = new BaseIncome();
        $income->base_id = $base;
        $income->product_id = $product;
        $income->contractor_id = $contractor;
        $income->qty = $qty;
        $income->remains_qty = $qty;
        $income->price = $price;
        $income->exchange = 1;
        $income->amount = $amount;
        $income->current_rate = $current_rate;
        $income->date = $date;
        $income->income_id = $id;
        if ($income->save()) return true;
        echo "<pre>";
        print_r($income->getErrors());
        echo "</pre>";
        exit();
    }
    public static function updateIncome($id, $qty, $price, $amount, $exchange)
    {
        $income = self::find()->where(['income_id' => $id])->one();
        $income->qty = $qty;
        $income->price = $price;
        $income->amount = $amount;
        $income->exchange = $exchange;
        if ($income->save()) return true;
        return false;
    }
    public static function updateIncomeByBase($id, $base, $current_rate, $date)
    {
        $income = self::find()->where(['income_id' => $id])->one();
        $income->base_id = $base;
        $income->current_rate = $current_rate;
        $income->date = $date;
        if ($income->save()) return true;
        return false;
    }
    public static function deleteIncome($id)
    {
        $income = self::find()->where(['income_id' => $id])->one();
        if ($income->delete()) return true;
        return false;
    }
}
