<?php

use backend\models\Contractors;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContractorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contractors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contractors-index">

    <h1><?= Html::encode($this->title) ?><?= Html::a(Yii::t('app', 'Create Contractors'), ['create'], ['class' => 'btn btn-success float-end']) ?></h1>
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
            'address:ntext',
            'gender',
            //'tel',
            //'inn',
            //'corporation',
            //'mfo_bank',
            //'photo',
            //'section_id',
            //'group_id',
            //'type_id',
            //'price_type',
            //'status',
            //'special',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Contractors $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
