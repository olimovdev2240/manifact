<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stages".
 *
 * @property int $id
 * @property int $place O`rni
 * @property int $convertme Konvertatsiya miqdori
 * @property string|null $name_uz Nomi (lotincha)
 * @property string|null $name_ru Nomi (krillcha)
 * @property float $price 1 dona maxsulot uchun to`lanadigan summa
 * @property string $position Biriktirilgan lavozimlar
 */
class Stages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place', 'position'], 'required'],
            [['place'], 'integer'],
            [['price'], 'number'],
            // [['position'], 'string'],
            [['name_uz', 'name_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'place' => Yii::t('app', 'O`rni'),
            'name_uz' => Yii::t('app', 'Nomi (lotincha)'),
            'name_ru' => Yii::t('app', 'Nomi (krillcha)'),
            'price' => Yii::t('app', '1 dona maxsulot uchun to`lanadigan summa'),
            'position' => Yii::t('app', 'Biriktirilgan lavozimlar'),
        ];
    }
}
