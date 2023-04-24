<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\WorkersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="workers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'full_name') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'passport') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'birth') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
