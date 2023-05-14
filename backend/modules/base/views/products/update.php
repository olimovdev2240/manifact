<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Products $model */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->name_uz]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ombor') ?></li>
        <li class="breadcrumb-item"><?= $this->title ?></li>
        <li class="breadcrumb-item active"><?= $model->name_uz ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/base/products/create">
                <span class="range-text"></span>
                <i class="icon-plus"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">



    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>