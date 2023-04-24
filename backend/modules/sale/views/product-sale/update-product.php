<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PsProducts */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Ombor</li>
        <li class="breadcrumb-item active">Omborlarni boshqarish</li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div class="ps-products-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'product_id')->dropDownList($products, ['onchange' => "getAttributes(this, {$base})", 'prompt' => '---']) ?>

        <?= $form->field($model, 'volume')->textInput(['maxlength' => true, 'id' => 'volume', 'readonly' => true]) ?>

        <?= $form->field($model, 'exchange')->checkbox() ?>

        <?= $form->field($model, 'qty')->textInput(['id' => 'qty', 'onkeyup' => 'sumOne()']) ?>

        <?= $form->field($model, 'price')->textInput(['id' => 'price', 'onkeyup' => 'sumOne()']) ?>

        <?= $form->field($model, 'amount')->textInput(['id' => 'amount', 'readonly' => true]) ?>

        <?= $form->field($model, 'fee')->textInput(['id' => 'fee', 'readonly' => true]) ?>

        <?= $form->field($model, 'special')->textInput(['id' => 'special', 'readonly' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>