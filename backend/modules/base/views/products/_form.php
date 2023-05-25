<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Products $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->input('number')->label('Tannarx') ?>

    <?= $form->field($model, 'type_id')->widget(Select2::classname(), [
        'data' => $types,
        'language' => 'ru',
        'options' => ['placeholder' => Yii::t('app', 'Tur')],
        'pluginOptions' => [
            // 'multiple' => true,
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'volume_id')->input('hidden', ['value' => 1])->label(false) ?>
    <?= $form->field($model, 'convertme')->widget(Select2::classname(), [
        'data' => $products,
        'language' => 'ru',
        'options' => ['placeholder' => Yii::t('app', 'Maxsulot')],
        'pluginOptions' => [
            // 'multiple' => true,
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'notif')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>