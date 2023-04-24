<?
function getUser($id, $array)
{
    foreach ($array as $a) :
        if ($a->id == $id) :
            return $a->username;
        endif;
    endforeach;
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ombor') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Omborlarni boshqarish') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/base/base/create">
                <span class="range-text"></span>
                <i class="icon-plus"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div class="row">
        <? foreach ($bases as $b) : ?>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <h5 title="<?= Yii::t('app', 'ID') ?>" class="user-name">#<?= $b->id ?></h5>
                                <h6 title="maxsulot nomi" class="user-email"><?= $b->name_uz ?></h6>
                            </div>
                            <div class="setting-links">
                                <a title="<?= Yii::t('app', 'Omborchi') ?>">
                                    <i class="icon-user"></i>
                                    <?= getUser($b->user_id, $users) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-center">
                        <a class="btn btn-sm btn-outline-info ml-1" href="/base/base/update?id=<?= $b->id ?>">
                            <i class="icon-pencil"></i>
                        </a>
                        <?php
                        if (Yii::$app->user->can('super admin')) {
                        ?>
                            <a class="btn btn-sm btn-outline-danger ml-1" href="/base/base/delete?id=<?= $b->id ?>" data-confirm="<?= Yii::t('app', 'Are you sure you want to delete this item?') ?>" data-method="post" title="<?= Yii::t('app', "Delete") ?>">
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