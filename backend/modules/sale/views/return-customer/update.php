<?php

use kartik\select2\Select2;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\ReturnCustomer */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->registerJsFile('/js/return-Customer-create.js');

?>

<div class="return-Customer-form">

    <?php $form = ActiveForm::begin(); ?>
    <?
    echo Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Xaridor attributlari'),
                'content' => $form->field($model, 'contractor_id')->widget(Select2::classname(), [
                    'data' => $contractors,
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) . "<div class='row'><div class='col-4'>" . $form->field($model, 'extra')->textInput(['maxlength' => true]) . "</div><div class='col-4'>" . $form->field($model, 'proxy')->textInput(['maxlength' => true]) . "</div><div class='col-4'>" . $form->field($model, 'bywhom')->textInput(['maxlength' => true]) . "</div><div class='col-12'> " . $form->field($model, 'comment')->textarea(['rows' => 6]) . "</div></div>",
                'active' => true
            ],
            [
                'label' => Yii::t('appp', 'Ombor'),
                'content' => "<div class='row'><div class='col-4'>" . $form->field($model, 'base_id')->widget(Select2::classname(), [
                    'data' => $bases,
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) . "</div></div>",
            ],
            [
                'label' => Yii::t('appp', 'Summalar'),
                'content' => "<div class='row'>
                    <div class='col-6'>" . $form->field($model, 'cost_sum')->textInput(['readonly' => true]) . "</div><div class='col-6'>" . $form->field($model, 'cost_usd')->textInput(['readonly' => true]) . "</div><div class='col-6'>" . $form->field($model, 'vat_sum')->textInput(['readonly' => true]) . "</div><div class='col-6'>" . $form->field($model, 'vat_usd')->textInput(['readonly' => true]) . "</div><div class='col-6'>" . $form->field($model, 'amount_sum')->textInput() . "</div><div class='col-6'>" . $form->field($model, 'amount_usd')->textInput() . "</div><div class='col-6'>" . $form->field($model, 'current_rate')->textInput(['id' => 'rate']) . "</div><div class='col-6'>" . $form->field($model, 'date')->input('date', ['onchange' => "getRateByDate(this.value)"]) . "</div></div>",
            ],
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>