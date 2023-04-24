<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ps_services".
 *
 * @property int $id
 * @property int $ps_id
 * @property int|null $worker_id Ishchi
 * @property int|null $service_id Xizmat
 * @property float|null $amount Summa
 * @property string|null $comment Izoh
 *
 * @property ProductSale $ps
 */
class PsServices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ps_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ps_id'], 'required'],
            [['ps_id', 'worker_id', 'service_id'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'string'],
            [['ps_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSale::className(), 'targetAttribute' => ['ps_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ps_id' => Yii::t('app', 'Ps ID'),
            'worker_id' => Yii::t('app', 'Ishchi'),
            'service_id' => Yii::t('app', 'Xizmat'),
            'amount' => Yii::t('app', 'Summa'),
            'comment' => Yii::t('app', 'Izoh'),
        ];
    }

    /**
     * Gets query for [[Ps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPs()
    {
        return $this->hasOne(ProductSale::className(), ['id' => 'ps_id']);
    }
}
