<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OfficeDebit */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('/backend/web/js/office-to-office.js');
?>

<div class="office-debit-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-4">
                <?= $form->field($model, 'user_id')->dropDownList([Yii::$app->user->id=>Yii::$app->user->identity->username], ['readonly'=>true]) ?>
        </div>
        <div class="col-4">
                <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => Yii::t('app', 'Enter date ...'),'onChange'=>'getRateByDate(this.value)'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy',
    ]
]); ?>
        </div>
        <div class="col-4">
                <?= $form->field($model, 'current_rate')->textInput(['readonly'=>true, 'id'=>'cr']) ?>
        </div>
    <div class="col-6">
        <? $offices = ArrayHelper::map($offices, 'id', 'name') ?>
        <?= $form->field($model, 'debit_office')->widget(Select2::classname(), [
                        'data' => $offices,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...'), 'onchange'=>'getAttr(this.value, \'debit\')'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
    </div>
    <div class="col-3 d-flex flex-column justify-content-end">
        <h6 class="remains"><?=Yii::t('app', 'So`mdagi qoldiq')?>: <span  id='debit-sum'>0</span> <?=Yii::t('app', 'so`m')?></h6>
    </div>
    <div class="col-3 d-flex flex-column justify-content-end">
        <h6 class="remains"><?=Yii::t('app', 'Valyutadagi qoldiq')?>: <span id='debit-usd'>0</span> <?=Yii::t('app', 'dollar')?></h6>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'outlay_office')->widget(Select2::classname(), [
                        'data' => $offices,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...'), 'onchange'=>'getAttr(this.value, \'outlay\')'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
    </div>
    <div class="col-3 d-flex flex-column justify-content-end">
        <h6 class="debts"><?=Yii::t('app', 'So`mdagi qoldiq')?>: <span  id='outlay-sum'>0</span> <?=Yii::t('app', 'so`m')?></h6>
    </div>
    <div class="col-3 d-flex flex-column justify-content-end">
        <h6 class="debts"><?=Yii::t('app', 'Valyutadagi qoldiq')?>: <span id='outlay-usd'>0</span> <?=Yii::t('app', 'dollar')?></h6>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'amount')->textInput(['id'=>'amount']) ?>
    </div>
    <div class="col-6 d-flex flex-column justify-content-end">
        <?= $form->field($model, 'exchange')->checkbox(['id'=>'exchange']) ?>
    </div>
    <div class="col-2 mt-4">
        <span class="btn btn-outline-info" onclick="convert()"><?=Yii::t('app', 'Konvertatsiya')?></span>
    </div>
    <div class="col-5">
        <?= $form->field($model, 'current_rate')->input('number', ['readonly'=>true, 'class'=>'my-rate form-control', 'onkeyup'=>'changeRate(this.value)', 'id'=>'customRate']) ?>
    </div>
    <div class="col-5">
        <?= $form->field($model, 'exchange_sum')->input('number', ['readonly'=>true, 'class'=>'my-rate form-control', 'id'=>'exchange_sum']) ?>
    </div>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

</div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success mt-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
