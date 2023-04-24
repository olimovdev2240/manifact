<?

use yii\bootstrap5\ActiveForm;

?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ishlab chiqarish') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Ish stoli') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/production/default/view-my-proccess" class="btn btn-success">
                <i class="icon-clock1"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <!-- <form method="POST" enctype="multipart/form-data"> -->
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="row mb-3">
        <div class="col-12">
            <label for=""><?= Yii::t('app', "Ish miqdori") ?>:</label>
        </div>
        <div class="col-12">
            <div class="w-100 d-flex flex-row justify-content-center">
                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary btn-lg" onclick="document.getElementById('qty').value = document.getElementById('qty').value * 1 + 1">+</button>
                    <input type="number" name="qty" class="btn btn-info btn-lg" min="0" id="qty">
                    <button type="button" class="btn btn-primary btn-lg" onclick="if(document.getElementById('qty').value*1 > 0){document.getElementById('qty').value = document.getElementById('qty').value * 1 - 1}">-</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <?= $form->field($model, 'product_id')->dropDownList($products, ['prompt' => '---']); ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <?= $form->field($model, 'photo')->fileInput() ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <button type="submit" class="btn btn-primary float-end"><?= Yii::t('app', 'Kiritish') ?></button>
        </div>
    </div>
    <!-- </form> -->
    <?php ActiveForm::end() ?>
</div>