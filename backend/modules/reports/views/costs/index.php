<?php

use backend\models\Costs;
use backend\models\PayOffices;
use backend\models\Sections;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Costs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Kassalarni boshqarish') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Kassa xarajatlari') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
    </ul>
</div>
<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); 
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        // 'office_id',
        [
            'attribute' => 'office_id',
            'filter' => ArrayHelper::map(PayOffices::find()->asArray()->all(), 'id', 'name'),
            'value' => function ($data) {
                return $data->office->name;
            }
        ],
        // 'user_id',
        [
            'attribute' => 'user_id',
            'filter' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),
            'value' => function ($data) {
                return $data->user->username;
            }
        ],
        // 'remains_sum',
        // 'cost_sum',
        [
            'attribute' => 'cost_sum',
            'format' => 'raw',
            'value' => function ($data) {
                $amount = number_format($data->cost_sum, 0, ',', ' ');
                return "<p style='text-align: right;'>{$amount}" . " " . Yii::t('app', 'so`m') . "</p>";
            }
        ],
        // 'remains_usd',
        // 'cost_usd',
        [
            'attribute' => 'cost_usd',
            'format' => 'raw',
            'value' => function ($data) {
                $amount = number_format($data->cost_usd, 0, ',', ' ');
                return "<p style='text-align: right;'>{$amount}" . " " . Yii::t('app', 'dollar') . "</p>";
            }
        ],
        // 'date',
        [
            'attribute' => 'date',
            'value' => function ($data) {
                return date("d/m/Y", strtotime($data->date));
            }
        ],
        //'current_rate',
        //'salary',
        //'expense',
        [
            'class' => ActionColumn::className(),
            'template' => '{view}',
            'urlCreator' => function ($action, Costs $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ],
]); ?>

<?php Pjax::end(); ?>

</div>