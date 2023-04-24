<?php

use backend\models\ProductSale;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product Sales');
$this->params['breadcrumbs'][] = $this->title;
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
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'contractor_id',
                'format' => 'raw',
                'filter' => $contractors,
                'value' => function ($data) {
                    if ($data->contractor_id != "") return $data->contractor->name;
                }
            ],
            [
                'attribute' => 'base_id',
                'format' => 'raw',
                'filter' => $bases,
                'value' => function ($data) {
                    if ($data->base_id != "") return $data->base->name_uz;
                }
            ],
            [
                'attribute' => 'office_id',
                'format' => 'raw',
                'filter' => $offices,
                'value' => function ($data) {
                    if ($data->office_id != "") return $data->office->name;
                }
            ],
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'filter' => $users,
                'value' => function ($data) {
                    if ($data->user_id != "") return $data->user->username;
                }
            ],
            // 'base_id',
            // 'contractor_id',
            // 'office_id',
            //'amount',
            //'exchange_amount',
            //'convertme',
            //'amount_convert',
            //'date',
            //'products:ntext',
            //'services:ntext',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, ProductSale $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>