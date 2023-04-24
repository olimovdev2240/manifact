<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OfficeToOfficeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-to-office-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'debit_office') ?>

    <?= $form->field($model, 'outlay_office') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'exchange') ?>

    <?php // echo $form->field($model, 'current_rate') ?>

    <?php // echo $form->field($model, 'exchange_sum') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
