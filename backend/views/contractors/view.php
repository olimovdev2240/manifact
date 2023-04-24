<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Contractors */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contractors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contractors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Close'), ['/'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'code',
            'name',
            'address:ntext',
            'gender',
            'tel',
            'inn',
            'corporation',
            'mfo_bank',
            // 'photo',
            [
                'attribute'=>'photo',
                'format'=>'raw',
                'value'=>function($data){
                    if($data->photo!=""){
                        return "<img src='/backend/web/contractor/{$data->photo}' width='200px'>";
                    }
                }
            ],
            
            [
                'attribute'=>'type.name',
                'label'=>Yii::t('app', 'Turi')
            ],
            [
                'attribute'=>'group.name',
                'label'=>Yii::t('app', 'Guruhi')
            ],
            // 'status',
            // 'special',
        ],
    ]) ?>

</div>
