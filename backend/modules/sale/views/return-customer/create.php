<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReturnCustomer */

$this->title = Yii::t('app', 'Create Return Customer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/js/return-customer-create.js');
?>

<?php $form = ActiveForm::begin(); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save and close'), ['class' => 'btn btn-success mb-3']) ?>
</div>

        <div class="row w-100">
            <div class="col-4 row">
                    <div class="col-3"><label for="rate"><?=Yii::t('app', "Kurs")?></label></div>
                    <div class="col-9"><?= $form->field($model, 'current_rate')->input('number', ['id'=>'rate', 'value'=>$rate])->label(false)?></div>
            </div>
            <div class="col-4">
                    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => Yii::t('app', 'Enter date ...'),'onChange'=>'getRateByDate(this.value)', 'onkeyup'=>'getRateByDate(this.value)'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                            ]
                        ])->label(false) ?>
            </div>

            <div class="col-4 row">
                    <div class="col-4"><label for="user_id"><?=Yii::t('app', "Foydalanuvchi")?></label></div>
                    <div class="col-8"><?= $form->field($model, 'user_id')->textInput(['id'=>'user_id', 'disabled'=>true, 'value'=>Yii::$app->user->identity->username])->label(false)?></div>
            </div>
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
        </div>
        <div class="container-fluid" style="box-shadow: 3px 3px 100px silver inset;">
            <?= $form->field($model, 'special')->widget(MultipleInput::className(), [
                            // 'max'               => 6,
                            'min'               => 1, // should be at least 2 rows
                            'allowEmptyList'    => false,
                            'enableGuessTitle'  => true,
                            // 'iconMap'=>MultipleInput::ICONS_SOURCE_FONTAWESOME,
                            'iconSource'=>MultipleInput::ICONS_SOURCE_FONTAWESOME,
                            'addButtonPosition' => MultipleInput::POS_FOOTER, // show add button in the header
                            'columns'=>[
                                [
                                    'name'  => 'product_id',
                                    'type'  => \kartik\select2\Select2::classname(),
                                    'title' => Yii::t('app', 'Maxsulot'),
                                     'options' => [
                                                    'data' => $products,
                                                    'options' => [
                                                        'placeholder' => Yii::t('app','Select state...'),
                                                        'onchange' => 'getVolume(this)',
                                                        'class'=>'product',
                                                    ],
                        
                                                ]
                                ],
                                [
                                    'name'=>'value',
                                    'title' => Yii::t('app', 'Birlik'),
                                    'enableError' => true,
                                    'options' =>[
                                        'readonly'=>'readonly',
                                        'class'=>'volume',
                                    ]
                                ],
                                [
                                    'name'=>'qty',
                                    'title' => Yii::t('app', 'Miqdor'),
                                    'enableError' => true,
                                    'options' =>[
                                        'class'=>'qty',
                                        'onblur'=>"sum()",
                                        'onkeyup'=>"sumOne()"
                                    ]
                                ],
                                [
                                    'name'=>'price',
                                    'title' => Yii::t('app', 'Narx'),
                                    'enableError' => true,
                                    'options' =>[
                                        'class'=>'price',
                                        'onblur'=>"sum()",
                                        'onkeyup'=>"sumOne()"
                                    ]
                                ],
                                [
                                    'name'=>'exchange',
                                    'title' => Yii::t('app', 'Valyuta'),
                                    'enableError' => true,
                                    'type'=>'checkbox',
                                    'options' =>[
                                        'class'=>'exchange',
                                        'onclick'=>"sum()"
                                    ]
                                ],
                                [
                                    'name'=>'amount',
                                    'title' => Yii::t('app', 'Summa'),
                                    'enableError' => true,
                                    'options' =>[
                                        'readonly'=>'readonly',
                                        'class'=>'amount',
                                    ]
                                ],
                                [
                                    'name'=>'vat_bet',
                                    'title' => Yii::t('app', 'QQS stavkasi'),
                                    'enableError' => true,
                                    'options' =>[
                                        'class'=>'vatbet',
                                        'onblur'=>"sum()",
                                        'onkeyup'=>"sumOne()"
                                    ]
                                ],
                                [
                                    'name'=>'amount_with_vat',
                                    'title' => Yii::t('app', 'QQS bilan summa'),
                                    'enableError' => true,
                                    'options' =>[
                                        'readonly'=>'readonly',
                                        'class'=>'amountwt',
                                    ]
                                ],
                                [
                                    'name'=>'fee',
                                    'title' => Yii::t('app', 'Tannarx'),
                                    'enableError' => true,
                                    'options' =>[
                                        'readonly'=>'readonly',
                                        'class'=>'fee',
                                    ]
                                ],
                                [
                                    'name'=>'remains',
                                    'title' => Yii::t('app', 'Qoldiq'),
                                    'enableError' => true,
                                    'options' =>[
                                        'readonly'=>'readonly',
                                        'class'=>'remains',
                                    ]
                                ],
                                
                            ]
                        ])
                        ->label(false)?>
        </div>
        <div class="row">
            <div class="col-6 row">
                    <div class="col-4"><p><?=Yii::t('app', "Summa (so`m)")?>:</p></div>
                    <div class="col-8">
                        <?= $form->field($model, 'cost_sum')->textInput(['id'=>'costSum', 'readonly'=>true])->label(false)?>
                    </div>
            </div>
            <div class="col-6 row">
                    <div class="col-4"><p><?=Yii::t('app', "Summa (usd)")?>:</p></div>
                    <div class="col-8">
                        <?= $form->field($model, 'cost_usd')->textInput(['id'=>'costUsd', 'readonly'=>true])->label(false)?>
                    </div>
            </div>
            <div class="col-6 row">
                    <div class="col-4"><p><?=Yii::t('app', "QQS (so`m)")?>:</p></div>
                    <div class="col-8">
                        <?= $form->field($model, 'vat_sum')->textInput(['id'=>'vatSum', 'readonly'=>true])->label(false)?>
                    </div>
            </div>
            <div class="col-6 row">
                    <div class="col-4"><p><?=Yii::t('app', "QQS (usd)")?>:</p></div>
                    <div class="col-8">
                        <?= $form->field($model, 'vat_usd')->textInput(['id'=>'vatUsd', 'readonly'=>true])->label(false)?>
                    </div>
            </div>
            <div class="col-6 row">
                    <div class="col-4"><p><?=Yii::t('app', "Umimiy summa (so`m)")?>:</p></div>
                    <div class="col-8">
                        <?= $form->field($model, 'amount_sum')->textInput(['id'=>'amountSum', 'readonly'=>true])->label(false)?>
                    </div>
            </div>
            <div class="col-6 row">
                    <div class="col-4"><p><?=Yii::t('app', "Umimiy summa (usd)")?>:</p></div>
                    <div class="col-8">
                        <?= $form->field($model, 'amount_usd')->textInput(['id'=>'amountUsd', 'readonly'=>true])->label(false)?>
                    </div>
            </div>
            <div class="col-12">
                <?=$form->field($model, 'comment')->textarea(['rows'=>5])?>
            </div>
            <div class="col-4">
                    <?= $form->field($model, 'extra')->textInput()?>
            </div>
            <div class="col-4">
                    <?= $form->field($model, 'proxy')->textInput()?>
            </div>
            <div class="col-4">
                    <?= $form->field($model, 'bywhom')->textInput()?>
            </div>
        </div>


    <?php ActiveForm::end(); ?>

