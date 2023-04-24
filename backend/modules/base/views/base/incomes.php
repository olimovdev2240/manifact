<?
function getProduct($id, $array)
{
    foreach ($array as $a) :
        if ($a->id == $id) :
            return $a->name_uz;
        endif;
    endforeach;
}
function getBase($id, $array)
{
    foreach ($array as $a) :
        if ($a->id == $id) :
            return $a->name_uz;
        endif;
    endforeach;
}
function getContractor($id, $array)
{
    foreach ($array as $a) :
        if ($a->id == $id) :
            return $a->name;
        endif;
    endforeach;
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ombor') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Kirimlar') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/base/base/income">
                <span class="range-text"></span>
                <i class="icon-plus"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div class="row">
        <? foreach ($model as $b) : ?>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <h5 title="<?= Yii::t('app', 'ID') ?>" class="user-name">#<?= $b->id ?></h5>
                                <h6 title="maxsulot nomi" class="user-email"><?= getProduct($b->product_id, $products) ?></h6>
                            </div>
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'Ta\'minotchi') ?>">
                                    <i class="icon-user"></i>
                                    <?
                                        if($b->contractor_id == ""){
                                            echo Yii::t('app', "Qoldiqdan");
                                        }else{
                                            echo getContractor($b->contractor_id, $contractors);
                                        }
                                    ?>
                                </a>
                                <a title="<?= Yii::t('app', 'Ta\'minotchi') ?>">
                                    <i class="icon-location_city"></i>
                                    <?= getBase($b->base_id, $bases) ?>
                                </a>
                                <a title="<?= Yii::t('app', 'Miqdori') ?>">
                                    <i class="icon-format_list_numbered"></i>
                                    <?= $b->qty ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-center">
                        <a class="btn btn-sm btn-outline-info ml-1" href="/base/base/update-income?id=<?= $b->id ?>">
                            <i class="icon-pencil"></i>
                        </a>
                        <?php
                        if (Yii::$app->user->can('super admin')) {
                        ?>
                            <a class="btn btn-sm btn-outline-danger ml-1" href="/base/base/delete-income?id=<?= $b->id ?>" data-confirm="<?= Yii::t('app', 'Are you sure you want to delete this item?') ?>" data-method="post" title="<?= Yii::t('app', "Delete") ?>">
                                <i class="icon-trash"></i>
                            </a>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        <? endforeach ?>
    </div>
</div>