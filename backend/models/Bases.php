<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bases".
 *
 * @property int $id
 * @property string $name_uz Nomi (Lotincha)
 * @property string $name_ru Nomi (Krillcha)
 * @property int $user_id Omborchi
 */
class Bases extends \yii\db\ActiveRecord
{
    const PAPER_BASE = 1;
    const MATERIAL_BASE = 2;
    const PRODUCT_BASE = 3;
    const INVERTAR_BASE = 4;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'user_id'], 'required'],
            [['user_id'], 'integer'],
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
            'name_uz' => Yii::t('app', 'Nomi (Lotincha)'),
            'name_ru' => Yii::t('app', 'Nomi (Krillcha)'),
            'user_id' => Yii::t('app', 'Omborchi'),
        ];
    }
}
