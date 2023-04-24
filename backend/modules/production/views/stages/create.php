<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Stages $model */

$this->title = Yii::t('app', 'Create Stages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?=Yii::t('app', 'Stages')?></li>
        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
    </ol>
</div>
<!-- Page header end -->
<div class="main-container">
    <?= $this->render('_form', [
        'model' => $model,
        'positions' => $positions
    ]) ?>

</div>