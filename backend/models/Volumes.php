<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "volumes".
 *
 * @property int $id
 * @property string $name Nomi
 */
class Volumes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'volumes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nomi'),
        ];
    }
    public static function getProductVolume($id){
        $sql = "
        SELECT v.name volume FROM products p 
            RIGHT JOIN volumes v 
            ON p.volume_id = v.id
            WHERE p.id = {$id}
        ";
        return Yii::$app->db->createCommand($sql)->queryOne();
    }
}
