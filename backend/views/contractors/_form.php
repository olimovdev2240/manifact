<?php

use backend\models\ContractorsGroup;
use backend\models\ContractorsType;
use backend\models\PricesType;
use backend\models\Sections;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap5\Tabs;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Contractors */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contractors-form">

    <?php $form = ActiveForm::begin(); ?>
    <?
    $section = ArrayHelper::map(Sections::find()->all(), 'id', 'name');
    $group = ArrayHelper::map(ContractorsGroup::find()->all(), 'id', 'name');
    $type = ArrayHelper::map(ContractorsType::find()->all(), 'id', 'name');
    $price = ArrayHelper::map(PricesType::find()->all(), 'id', 'name');
        echo Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'Attributlar'),
                    'content' => "<div class='row'>"."<div class='col-6'>".$form->field($model, 'code')->textInput(['maxlength' => true])."</div>"."<div class='col-6'>".$form->field($model, 'name')->textInput(['maxlength' => true])."</div>"."<div class='col-6'>".$form->field($model, 'gender')->radioList( [Yii::t('app','erkak')=>Yii::t('app','erkak'), Yii::t('app','ayol')=>Yii::t('app','ayol')], ['unselect' => Yii::t('app','erkak')] )."</div>"."<div class='col-6'>".$form->field($model, 'tel')->textInput(['maxlength' => true])."</div>".$form->field($model, 'address')->textarea(['rows' => 6]).$form->field($model, 'photo')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                    ])."</div>".$form->field($model, 'status')->checkbox(),
                    'active' => true
                ],
                [
                    'label' => Yii::t('app', 'Bog`lamlar'),
                    'content' => $form->field($model, 'section_id')->widget(Select2::classname(), [
                        'data' => $section,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]).$form->field($model, 'type_id')->widget(Select2::classname(), [
                        'data' => $type,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]).$form->field($model, 'price_type')->widget(Select2::classname(), [
                        'data' => $price,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]).$form->field($model, 'group_id')->widget(Select2::classname(), [
                        'data' => $group,
                        'language' => 'ru',
                        'options' => ['placeholder' => Yii::t('app', 'Select a state ...')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ,
                ],
                [
                    'label' => Yii::t('app', 'Rekvizitlar'),
                    'content' => $form->field($model, 'inn')->textInput(['maxlength' => true]).$form->field($model, 'corporation')->textInput(['maxlength' => true]).$form->field($model, 'mfo_bank')->textInput(['maxlength' => true]) ,
                ],
                // [
                //     'label' => 'Dropdown',
                //     'items' => [
                //          [
                //              'label' => 'DropdownA',
                //              'content' => 'DropdownA, Anim pariatur cliche...',
                //          ],
                //          [
                //              'label' => 'DropdownB',
                //              'content' => 'DropdownB, Anim pariatur cliche...',
                //          ],
                //     ],
                // ],
            ],
        ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
