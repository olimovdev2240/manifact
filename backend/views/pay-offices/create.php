<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PayOffices */

$this->title = Yii::t('app', 'Create Pay Offices');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-offices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
