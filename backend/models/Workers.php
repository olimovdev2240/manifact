<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "workers".
 *
 * @property int $id
 * @property int $user_id Foydalanuvchi
 * @property double $earn Ish haqi
 * @property string|null $full_name FIO
 * @property string|null $phone Telefon raqam
 * @property string|null $passport Passport seriya
 * @property string|null $address Manzil
 * @property string|null $birth Tug`ilgan sana
 * @property string|null $parent Ota-onasining malumotlari
 */
class Workers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['address', 'parent'], 'string'],
            [['birth'], 'safe'],
            [['earn'], 'safe'],
            [['full_name'], 'string', 'max' => 255],
            [['phone', 'passport'], 'string', 'max' => 20],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp'],

        ];
    }
    //rasm yuklanishi
    public function upload()
    {
        if ($this->validate()) {
            if($this->photo != ""){
                $this->photo->saveAs('workers/' . $this->photo->baseName . '.' . $this->photo->extension);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Foydalanuvchi'),
            'full_name' => Yii::t('app', 'FIO'),
            'phone' => Yii::t('app', 'Telefon raqam'),
            'passport' => Yii::t('app', 'Passport seriya'),
            'photo' => Yii::t('app', 'Rasm'),
            'address' => Yii::t('app', 'Manzil'),
            'birth' => Yii::t('app', 'Tug`ilgan sana'),
            'parent' => Yii::t('app', 'Ota-onasining malumotlari'),
        ];
    }
    public static function addSalary($earn, $worker){
        $model = self::find()
        ->where(['id'=>$worker])
        ->one();
        $model->earn += $earn;
        if($model->save()){
            return true;
        }else{
            echo "<pre>";
            print_r($model->getErrors());
            echo "</pre>";
            exit();
        }
    }
    public static function removeSalary($earn, $worker){
        $model = self::find()
        ->where(['id'=>$worker])
        ->one();
        $model->earn -= $earn;
        if($model->save()){
            return true;
        }else{
            echo "<pre>";
            print_r($model->getErrors());
            echo "</pre>";
            exit();
        }
    }
}
