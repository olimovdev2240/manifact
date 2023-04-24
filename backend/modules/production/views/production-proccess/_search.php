<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ProductionProccessSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-proccess-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'worker_id') ?>

    <?= $form->field($model, 'stage_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'packaging_type') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'salary') ?>

    <?php // echo $form->field($model, 'is_counted') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'counted_at') ?>

    <?php // echo $form->field($model, 'is_defective') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
