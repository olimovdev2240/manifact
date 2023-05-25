<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "come_report".
 *
 * @property int $id
 * @property int $worker_id Ishchi
 * @property string $date Kelgan vaqti
 * @property float $salary Ish uchun to`langan summa
 * @property int $checked Qabul qilinganmi
 */
class ComeReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'come_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['worker_id', 'date', 'salary'], 'required'],
            [['worker_id', 'checked'], 'integer'],
            [['date'], 'safe'],
            [['salary'], 'number'],
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
            'date' => Yii::t('app', 'Kelgan vaqti'),
            'salary' => Yii::t('app', 'Ish uchun to`langan summa'),
            'checked' => Yii::t('app', 'Qabul qilinganmi'),
        ];
    }
    public function getWorker()
    {
        return $this->hasOne(Workers::class, ['id' => 'worker_id']);
    }
}
