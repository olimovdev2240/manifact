<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contractors".
 *
 * @property int $id
 * @property string|null $code Kodi
 * @property string $name Nomi
 * @property string|null $address Manzili
 * @property string $gender
 * @property string|null $tel Telefoni
 * @property string|null $inn INN
 * @property string|null $corporation Tashkiloti
 * @property string|null $mfo_bank Bank MFO
 * @property string $photo Rasm
 * @property int|null $section_id Bo`lim
 * @property int|null $group_id Guruhi
 * @property int $type_id Turi
 * @property int $price_type Narx turi
 * @property int $status Status
 * @property string|null $special Maxsus parametri
 * @property float|null $debt_sum So`mdagi qarzdorlik
 * @property float|null $debt_usd Valyutadagi qarzdorlik
 * @property string|null $serial_passport Passport seriyasi
 * @property string|null $photo_passport Passport rasmi
 * @property string|null $photo_with_passport Passport bilan selfi
 * @property string|null $bails_tel Kafil raqami
 *
 * @property ContractorsGroup $group
 * @property PricesType $priceType
 * @property Sections $section
 * @property ContractorsType $type
 */
class Contractors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contractors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['address'], 'string'],
            [['section_id', 'group_id', 'type_id', 'price_type', 'status', 'user_id'], 'integer'],
            [['debt_sum', 'debt_usd'], 'number'],
            [['photo', 'photo_with_passport', 'photo_passport'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp'],
            [['code', 'name', 'corporation', 'special'], 'string', 'max' => 255],
            [['gender', 'inn', 'serial_passport'], 'string', 'max' => 50],
            [['tel', 'mfo_bank'], 'string', 'max' => 20],
            [['bails_tel'], 'string', 'max' => 20],
            // [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContractorsType::className(), 'targetAttribute' => ['type_id' => 'id']],
            // [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContractorsGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            // [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sections::className(), 'targetAttribute' => ['section_id' => 'id']],
            // [['price_type'], 'exist', 'skipOnError' => true, 'targetClass' => PricesType::className(), 'targetAttribute' => ['price_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Kodi'),
            'name' => Yii::t('app', 'Nomi'),
            'address' => Yii::t('app', 'Manzili'),
            'gender' => Yii::t('app', 'Gender'),
            'tel' => Yii::t('app', 'Telefoni'),
            'inn' => Yii::t('app', 'INN'),
            'corporation' => Yii::t('app', 'Tashkiloti'),
            'mfo_bank' => Yii::t('app', 'Bank MFO'),
            'photo' => Yii::t('app', 'Rasm'),
            'section_id' => Yii::t('app', 'Bo`lim'),
            'group_id' => Yii::t('app', 'Guruhi'),
            'type_id' => Yii::t('app', 'Turi'),
            'price_type' => Yii::t('app', 'Narx turi'),
            'status' => Yii::t('app', 'Status'),
            'special' => Yii::t('app', 'Maxsus parametri'),
            'debt_sum' => Yii::t('app', 'So`mdagi qarzdorlik'),
            'debt_usd' => Yii::t('app', 'Valyutadagi qarzdorlik'),
            'serial_passport' => Yii::t('app', 'Passport seriyasi'),
            'photo_passport' => Yii::t('app', 'Passport rasmi'),
            'photo_with_passport' => Yii::t('app', 'Passport bilan selfi'),
            'bails_tel' => Yii::t('app', 'Kafil raqami'),
            'user_id' => Yii::t('app', 'Login'),
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->photo->saveAs('contractor/' . $this->photo->baseName . '.' . $this->photo->extension);
            return true;
        } else {
            return false;
        }
    }
    public function uploads()
    {
        if ($this->validate()) {
            $this->photo->saveAs('contractor/' . $this->photo->baseName . '.' . $this->photo->extension);
            $this->photo_passport->saveAs('contractor/' . $this->photo_passport->baseName . '.' . $this->photo_passport->extension);
            $this->photo_with_passport->saveAs('contractor/' . $this->photo_with_passport->baseName . '.' . $this->photo_with_passport->extension);
            return true;
        } else {
            return false;
        }
    }
    public function uploadPhotos($photos){
        if ($this->validate()) {
            foreach ($photos as $photo) {
                $photo->saveAs('contractor/' . $photo->baseName . '.' . $photo->extension);
            }
            return true;
        } else {
            return false;
        }
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getGroup()
    // {
    //     return $this->hasOne(ContractorsGroup::className(), ['id' => 'group_id']);
    // }

    /**
     * Gets query for [[PriceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getPriceType()
    // {
    //     return $this->hasOne(PricesType::className(), ['id' => 'price_type']);
    // }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getSection()
    // {
    //     return $this->hasOne(Sections::className(), ['id' => 'section_id']);
    // }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getType()
    // {
    //     return $this->hasOne(ContractorsType::className(), ['id' => 'type_id']);
    // }
    //Qoldiqlar qoshib ketiladi
    public static function addRemains($w){
        $contractor = self::findOne($w['contractor_id']);
        $contractor->debt_sum += $w['cost_sum'];
        $contractor->debt_usd += $w['cost_usd'];
        if($contractor->save()) return true;
        echo "<pre>";
        print_r($contractor->getErrors());
        echo "</pre>";
        exit();
    }
    //Qoldiqlar ayrib ketiladi
    public static function removeRemains($w){
        $contractor = self::findOne($w['contractor_id']);
        $contractor->debt_sum -= $w['cost_sum'];
        $contractor->debt_usd -= $w['cost_usd'];
        if($contractor->save()) return true;
        return false;
    }
}
