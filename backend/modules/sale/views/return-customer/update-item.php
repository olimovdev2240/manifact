<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $m backend\ms\RsItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rs-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($m, 'rc_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($m, 'product_id')->dropDownList($products, ['class'=>'product form-control', 'onchange'=>'getVolume(this)']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($m, 'value')->textInput(['readonly' => true, 'class'=>'volume form-control',]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($m, 'qty')->textInput(['class'=>'qty form-control', 'onkeyup'=>'sumOne()']) ?>
        </div>
        <div class="col-4">
            <?= $form->field($m, 'price')->textInput(['class'=>'price form-control', 'onkeyup'=>'sumOne()']) ?>
        </div>
        <div class="col-4">
            <?= $form->field($m, 'amount')->textInput(['class'=>'amount form-control', 'onkeyup'=>'sumOne()']) ?>
        </div>
    </div>




    <?= $form->field($m, 'exchange')->checkbox(['onchange'=>'sumOne()']) ?>

    <?= $form->field($m, 'vat_bet')->textInput(['class'=>'vatbet form-control', 'onkeyup'=>'sumOne()']) ?>

    <?= $form->field($m, 'amount_with_vat')->textInput(['class'=>'amountwt form-control','readonly'=>true]) ?>

    <?= $form->field($m, 'fee')->textInput(['readonly'=>true]) ?>

    <?= $form->field($m, 'remains')->textInput(['readonly'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>