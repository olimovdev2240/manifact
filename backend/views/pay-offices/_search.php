<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PayOfficesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-offices-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class'=>'d-flex flex-row'
        ],
    ]); ?>

    <?//= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code')->label(false) ?>

    <?//= $form->field($model, 'name') ?>

    <?//= $form->field($model, 'bank') ?>

    <?//= $form->field($model, 'section_id') ?>

    <?php // echo $form->field($model, 'exchange') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton("<i class='fas fa-search'></i>", ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
