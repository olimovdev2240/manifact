<?php

use backend\models\Stages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\StagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Stages');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><? Yii::t('app', 'Ombor') ?></li>
        <li class="breadcrumb-item active"><? Yii::t('app', 'Omborlarni boshqarish') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
            'place',
            'name_uz',
            // 'name_ru',
            'price',
            // 'position:ntext',
        [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Stages $model, $key, $index, $column) {
        return Url::toRoute([$action, 'id' => $model->id]);
        }
        ],
        ],
        ]); ?>
    
    
</div>