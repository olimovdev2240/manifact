<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContractorsType */

$this->title = Yii::t('app', 'Create Contractors Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contractors Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contractors-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
