<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Contractors */

$this->title = Yii::t('app', 'Create Contractors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contractors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contractors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
