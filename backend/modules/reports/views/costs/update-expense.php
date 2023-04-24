<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $m backend\ms\ReportSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-salary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($m, 'cost_type')->dropDownList($type) ?>

    <?= $form->field($m, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($m, 'cost_sum')->textInput() ?>

    <?= $form->field($m, 'cost_usd')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success mt-3 float-end']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>