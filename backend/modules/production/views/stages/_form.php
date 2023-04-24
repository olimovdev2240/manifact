<?php

use cenotia\components\faiconSelector\FaiconSelector;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Stages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="stages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'place')->textInput() ?>

    <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'position')->widget(Select2::classname(), [
        'data' => $positions,
        'options' => [
            'multiple' => true,
            'placeholder' => Yii::t('app', 'Lavozimni tanlang'),

        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>