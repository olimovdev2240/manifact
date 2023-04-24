<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PsProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ps-products-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'service_id')->dropDownList($services, ['prompt'=>'---']) ?>

    <?= $form->field($model, 'worker_id')->dropDownList($workers, ['prompt'=>'---']) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows'=>6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>