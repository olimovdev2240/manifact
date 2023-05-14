<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "production_proccess".
 *
 * @property int $id
 * @property int|null $worker_id Bajargan ishchi
 * @property int $stage_id Etap nomi
 * @property int|null $product_id Chiqariladigan maxsulot
 * @property string $packaging_type
 * @property float $qty Bajarilgan ish miqdori
 * @property float $salary To`langan ish xaqi
 * @property int $is_counted Sanovchi tasdiqlaganmi
 * @property  $photo Ish rasmi
 * @property string|null $created_at Kiritilgan vaqti
 * @property string|null $counted_at Sanalgan vaqti
 * @property int $is_defective Brakka chiqqan
 * @property int $status Holati
 */
class ProductionProccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_proccess';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['worker_id', 'stage_id', 'product_id', 'is_counted', 'is_defective', 'status'], 'integer'],
            [['stage_id', 'packaging_type'], 'required'],
            [['packaging_type'], 'string'],
            [['qty', 'salary'], 'number'],
            [['created_at', 'counted_at'], 'safe'],
            // [['photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'worker_id' => Yii::t('app', 'Bajargan ishchi'),
            'stage_id' => Yii::t('app', 'Etap nomi'),
            'product_id' => Yii::t('app', 'Chiqariladigan maxsulot'),
            'packaging_type' => Yii::t('app', 'Qadoqlash usuli'),
            'qty' => Yii::t('app', 'Bajarilgan ish miqdori'),
            'salary' => Yii::t('app', 'To`langan ish xaqi'),
            'is_counted' => Yii::t('app', 'Sanovchi tasdiqlaganmi'),
            'photo' => Yii::t('app', 'Ish rasmi'),
            'created_at' => Yii::t('app', 'Kiritilgan vaqti'),
            'counted_at' => Yii::t('app', 'Sanalgan vaqti'),
            'is_defective' => Yii::t('app', 'Brakka chiqqan'),
            'status' => Yii::t('app', 'Holati'),
        ];
    }
    public function getWorker()
    {
        return $this->hasOne(Workers::className(), ['id' => 'worker_id']);
    }
    public function getStage()
    {
        return $this->hasOne(Stages::className(), ['id' => 'stage_id']);
    }
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->photo->saveAs('proccesses/' . $this->photo->baseName . $this->id . '.' . $this->photo->extension);
            return true;
        } else {
            return false;
        }
    }

    public function saveProccess()
    {
        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
        // exit();
        // $this->validateStageQty();
        if ($this->validateStageQty()) {
            $attached = Attach::find()->where(['product_id' => $this->product_id])->all();
            if (!empty($attached)) {
                foreach ($attached as $a) {
                    BaseRemains::removeQty(4, $a->invertor_id, $a->qty * $this->qty);
                }
            }
            // $pricing = Pricing::findOne(['product_id' => $this->product_id]);
            // if (empty($pricing->stage_id)) {
            //     Yii::$app->session->setFlash('warning', Yii::t('app', 'Etap narxlanmagan'));
            //     return false;
            // }
            // $this->stage_id = $pricing->stage_id;
            $this->packaging_type = 'turlanmagan';
            // $this->salary = $pricing->amout;
            $this->worker_id = Yii::$app->user->id;
            $this->created_at = date("Y-m-d H:i");
            if ($this->save()) {
                return true;
            } else {

                echo "<pre>";
                print_r($this->getErrors());
                echo "</pre>";
                exit();
            }
        }
    }
    public function saveProccessByManager()
    {
        if ($this->validateStageQty()) {
            BaseRemains::addQty($this->status, $this->product_id, $this->qty);
            Workers::addSalary($this->qty * $this->salary, $this->worker_id);
            $this->status = 0;
            $attached = Attach::find()->where(['product_id' => $this->product_id])->all();
            if (!empty($attached)) {
                foreach ($attached as $a) {
                    BaseRemains::removeQty(Bases::INVERTAR_BASE, $a->invertor_id, $a->qty * $this->qty);
                }
            }
            // $pricing = Pricing::findOne(['product_id' => $this->product_id]);
            // if (empty($pricing->stage_id)) {
            //     Yii::$app->session->setFlash('warning', Yii::t('app', 'Etap narxlanmagan'));
            //     return false;
            // }
            // $this->stage_id = $pricing->stage_id;
            $this->packaging_type = 'turlanmagan';
            // $this->salary = $pricing->amout;
            $this->is_counted = 1;
            $this->counted_at = date("Y-m-d H:i");
            $this->created_at = date("Y-m-d H:i");
            if ($this->save()) {
                return true;
            } else {

                echo "<pre>";
                print_r($this->getErrors());
                echo "</pre>";
                exit();
            }
        }
    }
    public function savePackage()
    {

        if ($this->validateStageQty()) {
            $attached = Attach::find()->where(['product_id' => $this->product_id])->all();
            if (!empty($attached)) {
                foreach ($attached as $a) {
                    BaseRemains::removeQty(4, $a->invertor_id, $a->qty * $this->qty);
                }
            }
            // $pricing = Pricing::findOne(['product_id' => $this->product_id]);
            // if (empty($pricing->stage_id)) {
            //     Yii::$app->session->setFlash('warning', Yii::t('app', 'Etap narxlanmagan'));
            //     return false;
            // }
            // $this->stage_id = $pricing->stage_id;
            // $this->packaging_type = 'turlanmagan';
            // $this->salary = $pricing->amout;
            $this->worker_id = Yii::$app->user->id;
            $this->created_at = date("Y-m-d H:i");
            if ($this->save()) {
                return true;
            } else {

                echo "<pre>";
                print_r($this->getErrors());
                echo "</pre>";
                exit();
            }
        }
    }
    public function validateStageQty()
    {
        if ($this->qty == "" || $this->product_id == "") {
            Yii::$app->session->setFlash('error', "Kerakli qiymatlar kiritilmagan!");
            return false;
        }
        //etaplash va narxlash
        $pricing = Pricing::find()->where(['product_id' => $this->product_id])->one();
        if (empty($pricing->stage_id)) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Etap narxlanmagan'));
            return false;
        }
        $this->stage_id = $pricing->stage_id;
        $this->salary = $pricing->amout;
        $thisGoal = $pricing->goal;
        $stages = Stages::find()->orderBy('place asc')->all();
        $thisPlace = 1;
        //avvalgi etapni topish
        foreach ($stages as $s) {
            if ($s->id == $this->stage_id) {
                $thisPlace = $s->place;
            }
        }
        if ($thisPlace == 1) {
            return true;
        } else {
            $perviousStageId = 1;
            foreach ($stages as $s) {
                if ($s->place == $thisPlace - 1) {
                    $perviousStageId = $s->id;
                }
            }
            //bitta avvalgi etapdagi product olinmoqda
            $myProduct = Products::find()->where(['id' => $this->product_id])->one();
            // echo "<pre>";
            // print_r($myProduct);
            // echo "</pre>";
            // exit();
            $myproduct_id = $myProduct->convertme;
            $sql = "SELECT sum(`qty` - `status`) as miqdor, production_proccess.* from production_proccess where stage_id = '{$perviousStageId}' AND product_id = {$myproduct_id} AND is_counted = 1 AND `qty` <> `status` Group by product_id";
            $perviousProducts = Yii::$app->db->createCommand($sql)->queryOne();
            // echo "<pre>";
            // print_r($perviousProducts);
            // echo "</pre>";
            // exit();
            if (empty($perviousProducts)) {
                Yii::$app->session->setFlash('error', "Miqdorlar avval qilingan etaplarga mos emas!");
                return false;
            }
            $myGoal = $perviousProducts['miqdor'] * $thisGoal;
            // echo Bases::MATERIAL_BASE;
            // echo $this->product_id - 1;
            // echo ceil($this->qty / $thisGoal);
            // exit;   
            if ($myGoal >= $this->qty) {
                BaseRemains::removeQty(Bases::MATERIAL_BASE, $myproduct_id, ceil($this->qty / $thisGoal));
                $qty = ceil($this->qty / $thisGoal);
                self::producting($perviousStageId, $myproduct_id, $qty);
                return true;
            }
            return false;
        }
    }
    private static function producting($oldStage, $product, $qty)
    {
        $sql = "SELECT  production_proccess.* from production_proccess where stage_id = {$oldStage} AND product_id = {$product} AND is_counted = 1 AND `qty` <> `status` order by created_at asc";
        $obj = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($obj as $p) :
            $id = $p['id'];
            if ($p['qty'] >= $qty) {
                $update = "UPDATE production_proccess set `status` = `status` + {$qty} where id = {$id}";
                Yii::$app->db->createCommand($update)->execute();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Jarayon muvaffaqiyatli tugatildi!'));
                return true;
            }
            $qty -= $p['qty'];
            $update = "UPDATE production_proccess set `status` = `qty` where id = {$id}";
            Yii::$app->db->createCommand($update)->execute();
        endforeach;
    }
}
