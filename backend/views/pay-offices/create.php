<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PayOffices */

$this->title = Yii::t('app', 'Create Pay Offices');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay Offices'), 'url' => ['index']];
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
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
