<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Bases $model */

$this->title = Yii::t('app', 'Create Bases');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?=Yii::t('app', 'Ombor')?></li>
        <li class="breadcrumb-item active"><?=$this->title?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/base/product/create">
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
    ]) ?>

</div>
