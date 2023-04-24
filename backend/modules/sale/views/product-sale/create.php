<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;


$this->title = Yii::t('app', 'Create Product Sale');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/backend/web/js/sale-ps-create.js");

?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Ombor</li>
        <li class="breadcrumb-item active">Omborlarni boshqarish</li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save and close'), ['class' => 'btn btn-success mb-2']) ?>
        </div>
        <div class="row mb-5">
            <div class="col-6 row shadow p-1">
                <div class="col-6">
                    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => Yii::t('app', 'Enter date ...'), 'onChange' => 'getRateByDate(this.value)'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy',
                        ]
                    ]); ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->identity->username, 'disabled' => true]) ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'base_id')->widget(Select2::classname(), [
                        'data' => $base,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...'), 'id' => 'base_id'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]) ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'contractor_id')->widget(Select2::classname(), [
                        'data' => $contractors,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...'),],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-9">
                    <?= $form->field($model, 'amount')->input('number', ['step' => '0.01', 'id' => 'amount']) ?>
                </div>
                <? $exchange = [
                    '1' => Yii::t('app', 'so`m'),
                    '2' => Yii::t('app', 'dollar')
                ] ?>
                <div class="col-3">
                    <?= $form->field($model, 'exchange_amount')->dropDownList($exchange, ['id' => 'exchange_amount', 'onchange' => 'sum()']) ?>
                </div>
            </div>
            <div class="col-5 offset-1">
                <div class="row shadow p-1 bg-info">
                    <div class="col-12">
                        <?= $form->field($model, 'office_id')->widget(Select2::classname(), [
                            'data' => $office,
                            'language' => 'ru',
                            'options' => ['placeholder' => Yii::t('app', 'Select a state ...'),],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>
                    </div>
                    <div class="col-12">
                        <?= $form->field($model, 'convertme')->checkbox(['onchange' => 'convertMe(this)']) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'current_rate')->input('number', ['step' => '0.01', 'id' => 'rate']) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'amount_convert')->input('number', ['step' => '0.01', 'id' => 'amount_convert']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?
        echo Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'Maxsulot'),
                    'content' => $form->field($model, 'products')->widget(MultipleInput::className(), [
                        // 'max'               => 6,
                        'min'               => 1, // should be at least 2 rows
                        'allowEmptyList'    => false,
                        'enableGuessTitle'  => true,
                        // 'iconMap'=>MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'addButtonPosition' => MultipleInput::POS_ROW, // show add button in the header
                        'columns' => [
                            [
                                'name'  => 'product_id',
                                'type'  => \kartik\select2\Select2::classname(),
                                'title' => Yii::t('app', 'Maxsulot'),
                                'options' => [
                                    'data' => $products,
                                    'options' => [
                                        'placeholder' => Yii::t('app', 'Select state...'),
                                        'onchange' => 'getAttributes(this)',
                                        'class' => 'product'
                                    ],

                                ]
                            ],
                            [
                                'name' => 'volume',
                                'title' => Yii::t('app', 'Birlik'),
                                'enableError' => false,
                                'options' => [
                                    'readonly' => true,
                                    'class' => 'volume',
                                ],
                            ],
                            [
                                'name' => 'exchange',
                                'title' => Yii::t('app', 'Valyuta'),
                                'enableError' => true,
                                'type' => 'checkbox',
                                'options' => [
                                    'class' => 'exchange',
                                    'onclick' => "sum()"
                                ]
                            ],
                            [
                                'name' => 'qty',
                                'title' => Yii::t('app', 'Miqdor'),
                                'enableError' => false,
                                'options' => [
                                    'class' => 'qty',
                                    'onkeyup' => 'sumOne()',
                                    'onblur' => 'sum()',
                                ]
                            ],
                            [
                                'name' => 'price',
                                'title' => Yii::t('app', 'Narx'),
                                'enableError' => false,
                                'options' => [
                                    'class' => 'price',
                                    'onkeyup' => 'sumOne()',
                                    'onblur' => 'sum()',
                                ]
                            ],
                            [
                                'name' => 'amount',
                                'title' => Yii::t('app', 'Summa'),
                                'enableError' => false,
                                'options' => [
                                    'class' => 'amount',
                                    'readonly' => true,
                                ],
                            ],
                            [
                                'name' => 'special',
                                'title' => Yii::t('app', 'Qoldiq'),
                                'enableError' => false,
                                'options' => [
                                    'class' => 'special',
                                    'readonly' => true,
                                ],
                            ],
                            [
                                'name' => 'fee',
                                'title' => Yii::t('app', 'Tannarx'),
                                'enableError' => false,
                                'options' => [
                                    'class' => 'fee',
                                    'readonly' => true,
                                ],
                            ],

                        ]
                    ])
                        ->label(false),
                    'active' => true,
                    'width' => "100%",
                ],
                [
                    'label' => Yii::t('app', 'Xizmatlar'),
                    'content' => $form->field($model, 'services')->widget(MultipleInput::className(), [
                        // 'max'               => 6,
                        'min'               => 1, // should be at least 2 rows
                        'layoutConfig' => [
                            'horizontalCssClasses' => [
                                'wrapper' => 'col-sm-12',
                            ],
                        ],
                        'allowEmptyList'    => false,
                        'enableGuessTitle'  => true,
                        // 'iconMap'=>MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'addButtonPosition' => MultipleInput::POS_ROW, // show add button in the header
                        'columns' => [
                            [
                                'name'  => 'worker_id',
                                'type'  => \kartik\select2\Select2::classname(),
                                'title' => Yii::t('app', 'Ishchi'),
                                'options' => [
                                    'data' => $workers,
                                    'options' => [
                                        'placeholder' => Yii::t('app', 'Select state...'),
                                    ],

                                ]
                            ],
                            [
                                'name'  => 'service_id',
                                'type'  => \kartik\select2\Select2::classname(),
                                'title' => Yii::t('app', 'Xizmat'),
                                'options' => [
                                    'data' => $services,
                                    'options' => [
                                        'placeholder' => Yii::t('app', 'Select state...'),
                                    ],

                                ]
                            ],
                            [
                                'name' => 'amount',
                                'title' => Yii::t('app', 'Summa'),
                                'enableError' => false,
                                'options' => [
                                    'class' => 'amount_service',
                                    'onkeyup' => 'sum()'
                                ]
                            ],
                            [
                                'name' => 'comment',
                                'title' => Yii::t('app', 'Izoh'),
                                'enableError' => false,
                            ],
                        ]
                    ])
                        ->label(false),
                ],

            ],
        ]);
        ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>