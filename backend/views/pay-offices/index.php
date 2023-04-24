<?php

use backend\models\PayOffices;
use backend\models\Sections;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PayOfficesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pay Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-offices-index">
    <h1><?= Html::encode($this->title) ?>  <?= Html::a(Yii::t('app', 'Create Pay Offices'), ['create'], ['class' => 'btn btn-success float-end']) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        'code',
                        'name',
                        // 'remains_sum',
                        [
                            'attribute'=>'remains_sum',
                            'format'=>'raw',
                            'value'=>function($data){
                                return "<p style='float: right'>".number_format($data->remains_sum, 0, '.', ' ')." ".Yii::t('app', 'so`m')."</p>";
                            }
                        ],
                        // 'remains_usd',
                        [
                            'attribute'=>'remains_usd',
                            'format'=>'raw',
                            'value'=>function($data){
                                return "<p style='float: right'>".number_format($data->remains_usd, 0, '.', ' ')." ".Yii::t('app', 'usd')."</p>";
                            }
                        ],
                        // 'bank',
                        [
                            'attribute'=>'bank',
                            'format'=>'raw',
                            'filter' => ['1'=>'Bankdagi', '0'=>'Korxonadagi'],
                            'value'=>function($data){
                                if($data->bank){
                                    $icon = Yii::t('app', 'ha');
                                    $btn = 'success';
                                }else{
                                    $icon = Yii::t('app', 'yo`q');
                                    $btn = 'danger';
                                }
                                return "<a class='badge badge-{$btn} bg-{$btn}' href='/pay-offices/set-bank?id={$data->id}'>{$icon}</a>";
                            }
                        ],
                        // 'status',
                        [
                            'attribute'=>'status',
                            'filter' => ['1'=>'Active', '0'=>'Activ emas'],
                            'format'=>'raw',
                            'value'=>function($data){
                                if($data->status){
                                    $icon = 'eye';
                                    $btn = 'success';
                                }else{
                                    $icon = 'eye-off';
                                    $btn = 'danger';
                                }
                                return "<a class='btn btn-{$btn}' href='/pay-offices/set-status?id={$data->id}'><i class='icon-{$icon}'></i></a>";
                            }
                        ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PayOffices $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
