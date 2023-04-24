<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Pricing $model */

$this->title = Yii::t('app', 'Update Pricing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pricings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">module</li>
        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-trash\'></i>'), ['delete', 'id' => $model->id], [
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">


    <?= $this->render('_form', [
        'model' => $model,

        'products' => $products,
        'stages' => $stages,
    ]) ?>

</div>