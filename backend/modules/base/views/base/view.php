<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Bases $model */

$this->title = Yii::t('app', 'Ko`rish');;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ombor') ?></li>
        <li class="breadcrumb-item"><?= $this->title ?></li>
        <li class="breadcrumb-item active"><?= $model->name_uz ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/base/base/create"  title="<?=Yii::t('app', "Update")?>">
                <span class="range-text"></span>
                <i class="icon-plus"></i>
            </a>
        </li>
        <li>
        <a href="/base/base/update?id=<?=$model->id?>" title="<?=Yii::t('app', "Update")?>" >
                <span class="range-text"></span>
                <i class="icon-pencil"></i>
            </a>
        </li>
        <li>
            <a href="/base/base/delete?id=<?=$model->id?>" data-confirm="<?= Yii::t('app', 'Are you sure you want to delete this item?') ?>" data-method="post" title="<?=Yii::t('app', "Delete")?>">
                <span class="range-text"></span>
                <i class="icon-trash"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name_uz',
            'name_ru',
            // 'user_id',
        ],
    ]) ?>

</div>