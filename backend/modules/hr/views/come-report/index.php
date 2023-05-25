<?php

use backend\models\ComeReport;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\ComeReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Come Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Омбор</li>
        <li class="breadcrumb-item active">Омборларни бошқариш</li>
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
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
            // 'worker_id',
            [
                'attribute' => 'worker_id',
                'value' => function($data){
                    // echo "<pre>";
                    // print_r($data->worker);
                    // echo "</pre>";
                    // exit();
                    return $data->worker->full_name;
                }
            ],
            'date',
            'salary',
            // 'checked',
            [
                'attribute'=> 'checked',
                'format' => 'html',
                'value' => function($data){
                    if($data->checked) return "<span class'btn btn-success'>".Yii::t('app', 'Qabul qilingan')."</span>";
                    return "<a href='/hr/come-report/accept?id={$data->id}' class='btn btn-danger'>".Yii::t('app', 'Yangi')."</a>";
                }
            ],
        [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, ComeReport $model, $key, $index, $column) {
        return Url::toRoute([$action, 'id' => $model->id]);
        }
        ],
        ],
        ]); ?>
    
        <?php Pjax::end(); ?>

</div>