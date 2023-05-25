<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Workers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="workers-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'user_id')->input('number', ['value' => Yii::$app->session->getFlash('special'), 'readonly' => true])   ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '+\\9\\9\\8 99 999 9999',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'passport')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => 'AA-9999999',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'birth')->input('date') ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'salary_of_day')->textInput() ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'type_of_work')->radioList(['0'=>Yii::t('app', 'Ishbay'), '1'=>Yii::t('app', 'Kunbay')]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <?= $form->field($model, 'photo')->fileInput() ?>
        </div>
        <div class="col-md-12 col-lg-6 col-12">
            <?= $form->field($model, 'parent')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-12 col-lg-6 col-12">
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>