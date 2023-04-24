<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Attach $model */

$this->title = Yii::t('app', 'Create Attach');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attaches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">module</li>
        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
    </ol>
</div>
<!-- Page header end -->
<div class="main-container">
    <?= $this->render('_form', [
        'model' => $model,
        'half' => $half,
        'material' => $material,
    ]) ?>

</div>