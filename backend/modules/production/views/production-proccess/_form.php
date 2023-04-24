<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ProductionProccess $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-proccess-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'worker_id')->textInput() ?>

    <?= $form->field($model, 'stage_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'packaging_type')->dropDownList([ 'turlanmagan' => 'Turlanmagan', '6 talik' => '6 talik', '60 talik' => '60 talik', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'salary')->textInput() ?>

    <?= $form->field($model, 'is_counted')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'counted_at')->textInput() ?>

    <?= $form->field($model, 'is_defective')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
