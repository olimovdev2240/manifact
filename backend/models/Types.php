<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "types".
 *
 * @property int $id
 * @property string|null $name_uz Lotincha nomi
 * @property string|null $name_ru Krillcha nomi
 * @property int|null $attached Biriktirilgan
 */
class Types extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attached'], 'integer'],
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
            'name_uz' => Yii::t('app', 'Lotincha nomi'),
            'name_ru' => Yii::t('app', 'Krillcha nomi'),
            'attached' => Yii::t('app', 'Biriktirilgan'),
        ];
    }
}
