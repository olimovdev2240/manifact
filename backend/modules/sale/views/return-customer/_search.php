<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReturnSupplierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="return-supplier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'contractor_id') ?>

    <?= $form->field($model, 'base_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'cost_sum') ?>

    <?php // echo $form->field($model, 'cost_usd') ?>

    <?php // echo $form->field($model, 'vat_sum') ?>

    <?php // echo $form->field($model, 'vat_usd') ?>

    <?php // echo $form->field($model, 'amount_sum') ?>

    <?php // echo $form->field($model, 'amount_usd') ?>

    <?php // echo $form->field($model, 'current_rate') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'proxy') ?>

    <?php // echo $form->field($model, 'bywhom') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'special') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
