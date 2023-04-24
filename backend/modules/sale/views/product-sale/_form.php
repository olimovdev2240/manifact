<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-sale-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'base_id')->textInput() ?>

    <?= $form->field($model, 'contractor_id')->textInput() ?>

    <?= $form->field($model, 'office_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'exchange_amount')->textInput() ?>

    <?= $form->field($model, 'convertme')->textInput() ?>

    <?= $form->field($model, 'amount_convert')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'products')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'services')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
