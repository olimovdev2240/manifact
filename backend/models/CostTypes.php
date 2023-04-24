<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cost_types".
 *
 * @property int $id
 * @property string|null $code Kodi
 * @property string $name Nomi
 */
class CostTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cost_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
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
        ];
    }
}
