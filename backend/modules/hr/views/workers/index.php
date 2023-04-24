<?php

use backend\models\Workers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\WorkersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Workers');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ishchilarni boshqarish') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Ishchilar ro`yxati') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['add']) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div style="overflow-x: scroll;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'user_id',
                'full_name',
                'phone',
                'passport',
                // 'photo',
                [
                    'attribute' => 'photo',
                    'format' => 'html',
                    'value' => function ($data) {
                        return "<img src='/workers/" . $data->photo . "' width='50px'>";
                    }
                ],
                //'address:ntext',
                //'birth',
                //'parent:ntext',
                [
                    'attribute' => 'user_id',
                    'label' => Yii::t('app', 'Lavozim biriktirish'),
                    'format' => 'html',
                    'value' => function ($data) {
                        return "<a class='btn btn-info' href='/admin/assignment/view?id={$data->user_id}'><i class='icon-account_circle' ></i> &nbsp;&nbsp;&nbsp;{$data->full_name}</a>";
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Workers $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>