<?php

use backend\models\Contractors;
use backend\models\ReturnCustomer;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReturnCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Return Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="return-Customer-index">

    <h1><?= Html::encode($this->title) ?><?= Html::a(Yii::t('app', 'Create Return Customer'), ['create'], ['class' => 'btn btn-success float-end']) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute'=>'contractor_id',
                'format'=>'raw',
                'filter'=>ArrayHelper::map(Contractors::find()->all(), 'id', 'name'),
                'value'=>function($data){
                    if($data->contractor_id!="") return $data->contractor->name;
                }
            ],
            [
                'attribute'=>'base_id',
                'format'=>'raw',
                'filter'=>$bases,
                'value'=>function($data){
                    if($data->base_id!="") return $data->base->name;
                }
            ],
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'filter'=>ArrayHelper::map(User::find()->all(), 'id', 'username'),
                'value'=>function($data){
                    if($data->user_id!="") return $data->user->username;
                }
            ],
            // 'cost_sum',
            //'cost_usd',
            //'vat_sum',
            //'vat_usd',
            //'amount_sum',
            //'amount_usd',
            //'current_rate',
            'extra',
            'proxy',
            'bywhom',
            //'comment:ntext',
            //'special:ntext',
            'date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReturnCustomer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
