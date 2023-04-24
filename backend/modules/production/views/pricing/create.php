<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Pricing $model */

$this->title = Yii::t('app', 'Create Pricing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pricings'), 'url' => ['index']];
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
    'products' => $products,
    'stages' => $stages,
    ]) ?>

</div>