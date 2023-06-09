<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OfficeToOffice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Office To Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="office-to-office-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Close'), ['/'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'user_id',
                'value'=>function($data){
                    return $data->user->username;
                }
            ],
            // 'office_id',
            [
                'attribute'=>'debit_office',
                'value'=>function($data){
                    return $data->debit->name;
                }
            ],
            // 'contractor_id',
            [
                'attribute'=>'outlay_office',
                'value'=>function($data){
                    return $data->outlay->name;
                }
            ],
            // 'amount',
            [
                'attribute'=>'amount',
                'format'=>'raw',
                'value'=>function($data){
                    $ex ="";
                    if($data->exchange){
                        $ex = Yii::t('app', 'dollar');
                    }else{
                        $ex = Yii::t('app', 'so`m');
                    }
                    $amount = number_format($data->amount, 0, ',', ' ');
                    return "<em>{$amount} {$ex}</em>";
                }
            ],
            [
                'attribute'=>'exchange_sum',
                'format'=>'raw',
                'value'=>function($data){
                    $ex ="";
                    if(!$data->exchange){
                        $ex = Yii::t('app', 'dollar');
                    }else{
                        $ex = Yii::t('app', 'so`m');
                    }
                    $amount = number_format($data->exchange_sum, 0, ',', ' ');
                    return "<em>{$amount} {$ex}</em>";
                }
            ],
            // 'exchange_sum',
            // 'exchange',
            [
                'attribute'=>'exchange',
                'filter' => ['1'=>Yii::t('app', 'dollar'), '0'=>Yii::t('app', 'so`m')],
                'value'=>function($data){
                    if($data->exchange){
                        return Yii::t('app', 'dollar');
                    }else{
                        return Yii::t('app', 'so`m');
                    }
                }
            ],
            'comment:ntext',
            // 'user_id',
            'current_rate',
            // 'date',
            [
                'attribute'=>'date',
                'value'=>function($data){
                    return date("d/m/Y", strtotime($data->date));
                }
            ],
        ],
    ]) ?>

</div>
