<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OfficeDebit */

$this->title = Yii::t('app', 'Create Office To Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Office Debits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-debit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'offices' => $offices
    ]) ?>

</div>
