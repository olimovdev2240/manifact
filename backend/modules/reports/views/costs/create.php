<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Costs */

$this->title = Yii::t('app', 'Create Costs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
        'office' => $office,
        'workers' => $workers,
    ]) ?>

</div>