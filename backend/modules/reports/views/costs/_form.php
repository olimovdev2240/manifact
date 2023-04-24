<?php
/* @var $this yii\web\View */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Tabs;

$this->title = Yii::t('app', 'Xarajatlarni shakllantirish');
$this->registerJsFile('/js/cost.js');
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-3 mt-auto',
            'offset' => 'col-sm-offset-3',
            'wrapper' => 'col-sm-9',
        ],
    ],
]); ?>
<div class="row owerflow-auto" style="height: 500px;">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save and close'), ['class' => 'btn btn-success mb-2']) ?>
    </div>
    <div class="col-lg-8 h-100 overflow-scroll">
        <?
        echo $form->field($model, 'salary')->widget(MultipleInput::className(), [
            // 'max'               => 6,
            'min'               => 1, // should be at least 2 rows
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
                    'name' => 'comment',
                    'title' => Yii::t('app', 'Izoh'),
                    'enableError' => false,
                ],
                [
                    'name' => 'cost_sum',
                    'title' => Yii::t('app', 'So`mda'),
                    'enableError' => false,
                    'options' => [
                        'class' => 'cost_sum',
                        'onblur' => "costSum(this.value)"
                    ]
                ],
                [
                    'name' => 'cost_usd',
                    'title' => Yii::t('app', 'Dollarda'),
                    'enableError' => false,
                    'options' => [
                        'class' => 'cost_usd',
                        'onblur' => "costUsd(this.value)"
                    ]
                ],
            ]
        ])
            ->label(false);
        ?>
    </div>
    <div class="col-lg-4" style="border-left: dashed 3px silver;">
        <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => Yii::t('app', 'Enter date ...'), 'onChange' => 'getRateByDate(this.value)'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
            ]
        ]); ?></span></p>
        <?= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->identity->username, 'disabled' => true]) ?>
        <?= $form->field($model, 'office_id')->widget(Select2::classname(), [
            'data' => $office,
            'language' => 'ru',
            'options' => ['placeholder' => Yii::t('app', 'Select a state ...'), 'onchange' => 'getAttr(this.value)'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
        <?= $form->field($model, 'remains_sum')->input('number', ['id' => 'remains_sum']) ?>
        <?= $form->field($model, 'cost_sum')->input('number', ['id' => 'amountSum']) ?>
        <?= $form->field($model, 'remains_usd')->input('number', ['id' => 'remains_usd']) ?>
        <?= $form->field($model, 'cost_usd')->input('number', ['id' => 'amountUsd']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>