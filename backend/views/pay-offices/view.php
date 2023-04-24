<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PayOffices */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pay-offices-view">

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
            'code',
            'name',
            // 'remains_sum',
            [
                'attribute'=>'remains_sum',
                'format'=>'raw',
                'value'=>function($data){
                    return "<p>".number_format($data->remains_sum, 0, '.', ' ')." ".Yii::t('app', 'so`m')."</p>";
                }
            ],
            // 'remains_usd',
            [
                'attribute'=>'remains_usd',
                'format'=>'raw',
                'value'=>function($data){
                    return "<p>".number_format($data->remains_usd, 0, '.', ' ')." ".Yii::t('app', 'usd')."</p>";
                }
            ],
            // 'bank',
            [
                'attribute'=>'bank',
                'format'=>'raw',
                'filter' => ['1'=>'Bankdagi', '0'=>'Korxonadagi'],
                'value'=>function($data){
                    if($data->bank){
                        $icon = Yii::t('app', 'ha');
                        $btn = 'success';
                    }else{
                        $icon = Yii::t('app', 'yo`q');
                        $btn = 'danger';
                    }
                    return "<a class='badge badge-{$btn} bg-{$btn}' href='/pay-offices/set-bank?id={$data->id}'>{$icon}</a>";
                }
            ],
            // 'status',
            [
                'attribute'=>'status',
                'filter' => ['1'=>'Active', '0'=>'Activ emas'],
                'format'=>'raw',
                'value'=>function($data){
                    if($data->status){
                        $icon = 'eye';
                        $btn = 'success';
                    }else{
                        $icon = 'eye-slash';
                        $btn = 'danger';
                    }
                    return "<a class='btn btn-{$btn}' href='/pay-offices/set-status?id={$data->id}'><i class='fa fa-{$icon}'></i></a>";
                }
            ],
        ],
    ]) ?>

</div>
