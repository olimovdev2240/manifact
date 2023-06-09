<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSaleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-sale-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'base_id') ?>

    <?= $form->field($model, 'contractor_id') ?>

    <?= $form->field($model, 'office_id') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'exchange_amount') ?>

    <?php // echo $form->field($model, 'convertme') ?>

    <?php // echo $form->field($model, 'amount_convert') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'products') ?>

    <?php // echo $form->field($model, 'services') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
