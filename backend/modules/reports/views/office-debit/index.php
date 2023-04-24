<?php

use backend\models\Contractors;
use backend\models\OfficeDebit;
use backend\models\PayOffices;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OfficeDebitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Office Debits');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-debit-index">

    <h1><?= Html::encode($this->title) ?><?= Html::a(Yii::t('app', 'Create Office Debit'), ['create'], ['class' => 'btn btn-success float-end']) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'office_id',
            [
                'attribute'=>'office_id',
                'filter' => ArrayHelper::map(PayOffices::find()->asArray()->all(), 'id', 'name'),
                'value'=>function($data){
                    return $data->office->name;
                }
            ],
            // 'contractor_id',
            [
                'attribute'=>'contractor_id',
                'filter' => ArrayHelper::map(Contractors::find()->asArray()->all(), 'id', 'name'),
                'value'=>function($data){
                    return $data->contractor->name;
                }
            ],
            // 'amount',
            [
                'attribute'=>'amount',
                'format'=>'raw',
                'value'=>function($data){
                    $amount = number_format($data->amount, 0, ',', ' ');
                    return "<p style='text-align: right;'>{$amount}</p>";
                }
            ],
            // 'exchange',
            [
                'attribute'=>'exchange',
                'filter' => ['1'=>Yii::t('app', 'dollar'), '0'=>Yii::t('app', 'so`m')],
                'value'=>function($data){
                    if($data->exchange){
                        return Yii::t('app', 'dollar');
                    }else{
                        return Yii::t('app', 'so`m');
                    }
                }
            ],
            // 'comment:ntext',
            // 'user_id',
            //'current_rate',
            // 'date',
            [
                'attribute'=>'date',
                'value'=>function($data){
                    return date("d/m/Y", strtotime($data->date));
                }
            ],
            //'exchange_sum',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, OfficeDebit $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
