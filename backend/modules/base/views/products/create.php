<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Products $model */

$this->title = Yii::t('app', 'Create Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ombor') ?></li>
        <li class="breadcrumb-item active"><?= $this->title ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/base/base/create">
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