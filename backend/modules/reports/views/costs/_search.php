<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CostsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="costs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'office_id') ?>

    <?= $form->field($model, 'section_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'remains_sum') ?>

    <?php // echo $form->field($model, 'cost_sum') ?>

    <?php // echo $form->field($model, 'remains_usd') ?>

    <?php // echo $form->field($model, 'cost_usd') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'current_rate') ?>

    <?php // echo $form->field($model, 'salary') ?>

    <?php // echo $form->field($model, 'expense') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
