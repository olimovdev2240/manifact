<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Workers $model */

$this->title = Yii::t('app', 'Create Workers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workers'), 'url' => ['index']];
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