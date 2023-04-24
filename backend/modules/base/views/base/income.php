<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductIncome */

$this->title = Yii::t('app', 'Create Product Income');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Incomes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/js/base-pi-create.js');
?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save and close'), ['class' => 'btn btn-success mb-3']) ?>
        </div>

        <div class="row w-100">
            <div class="col-6">
                <?= $form->field($model, 'base_id')->widget(Select2::classname(), [
                    'data' => $bases,
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('app', 'Ombor')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'contractor_id')->widget(Select2::classname(), [
                    'data' => $contractors,
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t('app', 'Ta\'minotchi')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-6 row">
                <div class="col-4">
                    <p><?= Yii::t('app', "Summa (so`m)") ?>:</p>
                </div>
                <div class="col-8">
                    <?= $form->field($model, 'amount')->textInput(['id' => 'amountSum', 'readonly' => true])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="box-shadow: 3px 3px 100px silver inset; overflow: scroll;">
            <?= $form->field($model, 'special')->widget(MultipleInput::className(), [
                // 'max'               => 6,
                'min'               => 1, // should be at least 2 rows
                'allowEmptyList'    => false,
                'enableGuessTitle'  => true,
                // 'iconMap'=>MultipleInput::ICONS_SOURCE_FONTAWESOME,
                'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                'addButtonPosition' => MultipleInput::POS_FOOTER, // show add button in the header
                'columns' => [
                    [
                        'name'  => 'product_id',
                        'type'  => \kartik\select2\Select2::classname(),
                        'title' => Yii::t('app', 'Maxsulot'),
                        'options' => [
                            'data' => $products,
                            'options' => [
                                'placeholder' => Yii::t('app', 'Select state...'),
                                'onchange' => 'getVolume(this)',
                                'class' => 'product'
                            ],

                        ]
                    ],
                    [
                        'name' => 'volume',
                        'title' => Yii::t('app', 'Birlik'),
                        'enableError' => true,
                        'options' => [
                            'readonly' => 'readonly',
                            'class' => 'volume',
                        ]
                    ],
                    [
                        'name' => 'qty',
                        'title' => Yii::t('app', 'Miqdor'),
                        'enableError' => true,
                        'options' => [
                            'class' => 'qty',
                            'onblur' => "sumOne()",
                            'onkeyup' => "sum()"
                        ]
                    ],
                    [
                        'name' => 'price',
                        'title' => Yii::t('app', 'Narx'),
                        'enableError' => true,
                        'options' => [
                            'class' => 'price',
                            'onblur' => "sumOne()",
                            'onkeyup' => "sum()"
                        ]
                    ],
                    [
                        'name' => 'amount',
                        'title' => Yii::t('app', 'Summa'),
                        'enableError' => true,
                        'options' => [
                            'readonly' => 'readonly',
                            'class' => 'amount',
                        ]
                    ],
                ]
            ])
                ->label(false) ?>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</main> 