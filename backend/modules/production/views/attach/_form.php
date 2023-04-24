<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Attach $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="attach-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
        'data' => $half,
        'options' => [
            'placeholder' => Yii::t('app', 'Yarimtayyor maxsulotlar'),

        ],
    ]); ?>

    <?= $form->field($model, 'invertor_id')->widget(Select2::classname(), [
        'data' => $material,
        'options' => [
            'placeholder' => Yii::t('app', 'Homashyolar'),

        ],
    ]); ?>

    <?= $form->field($model, 'qty')->input('number') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>