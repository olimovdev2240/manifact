<?php

use backend\models\ProductionProccess;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\ProductionProccessSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Production Proccesses');
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
            // 'worker_id',
            [
                'attribute'=>'worker_id',
                'format'=>'html',
                'value'=>function($model){
                    return $model->worker->full_name;
                }
            ],
            [
                'attribute'=>'stage_id',
                'format'=>'html',
                'value'=>function($model){
                    return $model->stage->name_uz;
                }
            ],
            // 'stage_id',
            // 'product_id',
            [
                'attribute'=>'product_id',
                'format'=>'html',
                'value'=>function($model){
                    return $model->product->name_uz;
                }
            ],
            // 'packaging_type',
            'qty',
            //'salary',
            // 'is_counted',
            [
                'attribute' => 'is_counted',
                'format' => 'html',
                'value' => function($model){
                    if(!$model->is_counted) return "<a href='/production/production-proccess/count?id={$model->id}' class='btn btn-danger'> sanalmagan</a>";
                    return "<a href='#' class='btn btn-success'> sanalgan</a>";
                }
            ],
            [
                'attribute' => 'is_defective',
                'format' => 'html',
                'value' => function($model){
                    if($model->is_defective) return "<input type='number' max = '{$model->qty}' min='0' class='form-inline'><a href='/production/production-proccess/abort?id={$model->id}' class='btn btn-danger'> brak</a>";
                    return "<input type='number' max = '{$model->qty}' min='0' class='form-inline'><a href='/production/production-proccess/abort?id={$model->id}' class='btn btn-success'> toza</a>";
                }
            ],
            // 'photo',
            'created_at',
            'counted_at',
            //'is_defective',
            //'status',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>