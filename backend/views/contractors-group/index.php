<?php

use backend\models\ContractorsGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContractorsGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contractors Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contractors-group-index">

    <h1><?= Html::encode($this->title) ?> <?= Html::a(Yii::t('app', 'Create Contractors Group'), ['create'], ['class' => 'btn btn-success float-end']) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ContractorsGroup $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
