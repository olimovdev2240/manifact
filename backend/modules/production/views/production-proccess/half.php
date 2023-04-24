<?php

use backend\models\ProductionProccess;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
function getStatus ($model){
    if(!$model->is_counted) return "<span class='badge bg-danger'> sanalmagan</span>";
    return "<span class='badge bg-success'> sanalgan</span>";
}
/** @var yii\web\View $this */
/** @var backend\models\ProductionProccessSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Production Proccesses');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Sanovchi') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Maxsulotlarni tasdiqlash') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <? //= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) 
            ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div class="row">
        <form method="POST">
            <div class="input-group mb-3">
                <input type="search" class="form-control" placeholder="<?= Yii::t('app', 'ism yoki maxsulot kiriting') ?>" name="search">
                <button class="btn btn-outline-info" type="submit" id="">
                    <i class="icon-search"></i>
                </button>
            </div>
        </form>
        <? foreach ($model as $m) : ?>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'ID') ?>">
                                    <i class="icon-user"></i>
                                    #<?= $m->id ?>
                                </a>
                            </div>
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'Ishchi') ?>">
                                    <i class="icon-user"></i>
                                    <?= $m->worker->full_name ?>
                                </a>
                            </div>
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'Maxsulot') ?>">
                                    <i class="icon-maximize"></i>
                                    <?= $m->product->name_uz ?>
                                </a>
                            </div>
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'Miqdori') ?>">
                                    <i class="icon-document-landscape"></i>
                                    <?= $m->qty ?>
                                    <?=getStatus($m)?>
                                </a>
                            </div>
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'Brak') ?>">
                                    <i class="icon-cancel"></i>
                                    <input onblur="setAbort(<?=$m->id?>, this.value, <?=$m->qty?>)" type="number" class="form-control" value="<?= $m->invalid ?>" min='0' max='<?= $m->qty ?>'>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-center">
                        <a class="btn btn-sm btn-success ml-1" href="count?id=<?= $m->id ?>">
                            <i class="icon-check"></i>
                        </a>
                    </div>
                </div>
            </div>
        <? endforeach ?>
        <?
        echo LinkPager::widget([
            'pagination' => $pagination,
        ]);
        ?>
    </div>
</div>
<script>
    function setAbort(id, val, maxval){
        id = Number(id)
        val = Number(val) 
        maxval = Number(maxval)
        if( val > maxval ){
            alert("<?=Yii::t('app', 'Miqdor juda katta')?>")
            return false
        }
        if( val < 0 ){
            alert("<?=Yii::t('app', 'Braklar miqdori noto`g`ri kiritilgan')?>")
            return false
        }
        window.location.href  = "/production/production-proccess/abort?id=" + id + "&val=" +val

    }
</script>