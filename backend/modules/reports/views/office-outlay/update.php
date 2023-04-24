<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OfficeDebit */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Office Outlays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="office-debit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('update_form', [
        'model' => $model,
        'offices' => $offices,
        'contractors' => $contractors,
    ]) ?>


</div>
