<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Pricing $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pricing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($products, ['prompt' => "---"]) ?>

    <?= $form->field($model, 'stage_id')->dropDownList($stages, ['prompt' => "---"]) ?>

    <?= $form->field($model, 'amout')->textInput() ?>

    <?= $form->field($model, 'goal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>