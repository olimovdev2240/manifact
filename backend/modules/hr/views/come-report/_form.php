<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ComeReport $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="come-report-form shadow-lg p-3">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
            <?= $form->field($model, 'worker_id')->widget(Select2::classname(), [
                        'data' => $workers,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])  ?>
        </div>
        <? if ($model->date == "") { ?>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                <?= $form->field($model, 'date')->input('datetime-local', ['value' => date("Y-m-d H:i", strtotime(date('YmdHis').' +2hours'))]) ?>
            </div>
        <? } else {
        ?>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                <?= $form->field($model, 'date')->input('datetime-local') ?>
            </div>
        <?
        } ?>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
            <?= $form->field($model, 'salary')->textInput() ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
            <?= $form->field($model, 'checked')->checkbox() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>