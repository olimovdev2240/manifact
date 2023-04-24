<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OfficeDebitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-debit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'office_id') ?>

    <?= $form->field($model, 'contractor_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'exchange') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'current_rate') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'exchange_sum') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
