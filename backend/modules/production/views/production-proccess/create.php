<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ProductionProccess $model */

$this->title = Yii::t('app', 'Create Production Proccess');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Production Proccesses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">module</li>
        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
    </ol>
</div>
<!-- Page header end -->
<div class="main-container">
    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>