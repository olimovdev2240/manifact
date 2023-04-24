<?php

use backend\models\Stages;
use kartik\sortable\Sortable;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\StagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Stages');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ishlab chiqarish boshqaruvi') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Etaplar') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
            <?
            echo Sortable::widget([
                'items' => $items
            ]);
            ?>
        </div>
    </div>
    <button class="btn btn-primary mt-3" onclick="saveChanges()">
        <?
        echo Yii::t('app', 'O`zgarishlarni saqlash');
        ?>
    </button>

</div>
<script>
    function saveChanges() {
        let myClasses = $('.myItem')
        let myNumbers = $('.myNumber')
        let myArray = {}
        for (let i = 0; i < myClasses.length; i++) {
            myArray[i] = myNumbers[i].innerText
        }
        $.post('/production/stages/update-place', // url
            {
                data: myArray
            }, // data to be submit
            function(data, status, xhr) { // success callback function
                // alert('status: ' + status + ', data: ' + data);
                console.log(data)
            },
            'json'); // response data format
    }
</script>