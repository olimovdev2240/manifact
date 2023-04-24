<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/** @var yii\web\View $this */
/** @var backend\models\Stages $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stages'), 'url' => ['index']];
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
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
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
                'id',
            'place',
            'name_uz',
            'name_ru',
            'price',
            'position:ntext',
    ],
    ]) ?>

</div>