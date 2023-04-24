<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "remains_workers".
 *
 * @property int $id
 * @property int $worker_id Ishchi
 * @property string|null $comment Izoh
 * @property float|null $cost_sum So`mdagi summa
 * @property float|null $cost_usd Dollardagi summa
 * @property int $nodebt Xaqorlik
 * @property string|null $date Sana
 * @property float $current_rate Kurs
 * @property int $user_id Foydalanuvchi
 * @property string|null $special
 */
class RemainsWorkers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remains_workers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['worker_id', 'current_rate'], 'required'],
            [['worker_id', 'nodebt', 'user_id'], 'integer'],
            [['comment'], 'string'],
            [['cost_sum', 'cost_usd', 'current_rate'], 'number'],
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
            'worker_id' => Yii::t('app', 'Ishchi'),
            'comment' => Yii::t('app', 'Izoh'),
            'cost_sum' => Yii::t('app', 'So`mdagi summa'),
            'cost_usd' => Yii::t('app', 'Dollardagi summa'),
            'nodebt' => Yii::t('app', 'Xaqorlik'),
            'date' => Yii::t('app', 'Sana'),
            'current_rate' => Yii::t('app', 'Kurs'),
            'user_id' => Yii::t('app', 'Foydalanuvchi'),
            'special' => Yii::t('app', 'Special'),
        ];
    }
    //qoldiqlarni yuklash
    public static function getAdditionalAttributes($id){
        $sql = "SELECT rw.id id, worker_id, w.name worker, rw.date date, rw.comment comment, rw.cost_sum cost_sum, rw.cost_usd cost_usd, rw.nodebt nodebt FROM remains_workers rw
        LEFT JOIN workers w 
        ON w.id = rw.worker_id
        WHERE rw.worker_id = {$id}";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        return $data;
    }
}
