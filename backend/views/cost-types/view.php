<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CostTypes */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cost Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">module</li>
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ko`rish') ?></li>
        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['add']) ?>
        </li>
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-pencil\'></i>'), ['update', 'id' => $model->id]) ?>
        </li>
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-trash\'></i>'), ['delete', 'id' => $model->id], [
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'code',
            'name',
        ],
    ]) ?>

</div>