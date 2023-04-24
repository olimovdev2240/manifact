<?php

use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSale */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
function isNotNull($num)
{
    if ($num == null) return 0;
    return $num;
}
$this->registerJsFile('/backend/web/js/sale-ps-view.js');
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Ombor</li>
        <li class="breadcrumb-item active">Omborlarni boshqarish</li>
    </ol>

    <ul class="app-actions">
        <li>
            <?= Html::a(Yii::t('app', '<i class=\'icon-plus\'></i>'), ['create']) ?>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'contractor_id',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->contractor_id != "") return $data->contractor->name;
                }
            ],
            [
                'attribute' => 'base_id',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->base_id != "") return $data->base->name_uz;
                }
            ],
            [
                'attribute' => 'office_id',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->office_id != "") return $data->office->name;
                }
            ],
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->user_id != "") return $data->user->username;
                }
            ],
            // 'amount',
            [
                'attribute' => 'amount',
                'format' => 'html',
                'value' => function ($data) {
                    return number_format($data->amount, 2, '.', ' ');
                }
            ],
            // 'exchange_amount',
            // 'convertme',
            // 'amount_convert',
            // [
            //     'attribute' => 'amount_convert',
            //     'format' => 'html',
            //     'value' => function ($data) {
            //         if (($data->convertme && $data->exchange_amount == 1) || (!$data->convertme && $data->exchange_amount == 2)) {
            //             $p = 2;
            //         } else {
            //             $p = 1;
            //         }
            //         return number_format($data->amount_convert, 2, '.', ' ') . " " . Yii::$app->params['exchange'][$p];
            //     }
            // ],
            'date',
            // 'products:ntext',
            // 'services:ntext',
        ],
    ]) ?>
    <?
    $products = "
    <table class='table table-hover table-inverse table-responsive'>
        <thead class='thead-inverse'>
            <tr>
                <th>" . Yii::t('app', 'Maxsulot') . "</th>
                <th>" . Yii::t('app', 'Miqdor') . "</th>
                <th>" . Yii::t('app', 'Narx') . "</th>
                <th>" . Yii::t('app', 'Summa') . "</th>
                <th>" . Yii::t('app', 'Tannarx') . "</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
    ";
    foreach ($model->products as $s) {

        $products .= "
        <tr>
            <td>" . $s['product'] . "</td>
            <td>" . number_format($s['qty'], 2, '.', ' ') . " " . $s['volume'] . "</td>
            <td>" . number_format($s['price'], 2, '.', ' ') . "</td>
            <td>" . number_format($s['amount'], 2, '.', ' ') . "</td>
            <td>" . number_format(isNotNull($s['fee']), 2, '.', ' ') . "</td>
            <td>
                <button type='button' class='btn btn-primary' onclick='getModelProduct(" . $s['id'] . ", {$model->base_id})' data-bs-toggle='modal' data-bs-target='#m" . $s['id'] . "'>
                    <i class='icon-pencil'></i>
                </button>
                <a class='btn btn-danger' href='/sale/product-sale/delete-product?id=" . $s['id'] . "&base=" . $model->base_id . "'>
                    <i class='icon-trash'></i>
                </a>
                <div class='modal fade' id='m" . $s['id'] . "' tabindex='-1' aria-labelledby='m" . $s['id'] . "Label' aria-hidden='true'>
                    <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h5 class='modal-title' id='m" . $s['id'] . "Label'>" . Yii::t('app', 'Update') . "</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' id='content" . $s['id'] . "'>
                        
                        </div>
                    </div>
                    </div>
                </div>
          </td>
        </tr>
        ";
    }
    $products .= "</tbody></table>";
    $services = "
    <table class='table table-hover table-inverse table-responsive'>
        <thead class='thead-inverse'>
            <tr>
                <th>" . Yii::t('app', 'Ishchi') . "</th>
                <th>" . Yii::t('app', 'Xizmat') . "</th>
                <th>" . Yii::t('app', 'Summa') . "</th>
                <th>" . Yii::t('app', 'Izoh') . "</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
    ";
    foreach ($model->services as $s) {
        $services .= "
        <tr>
            <td>" . $s['worker'] . "</td>
            <td>" . $s['service'] . "</td>
            <td>" . number_format($s['amount'], 2, '.', ' ') . " " . Yii::t('app', 'so`m') . "</td>
            <td>" . $s['comment'] . "</td>
            <td>
                <button type='button' class='btn btn-primary' onclick='getModelService(" . $s['id'] . ")' data-bs-toggle='modal' data-bs-target='#m" . $s['id'] . "'>
                    <i class='icon-pencil'></i>
                </button>
                <a class='btn btn-danger' href='/sale/product-sale/delete-service?id=" . $s['id'] . "'>
                    <i class='icon-trash'></i>
                </a>
                <div class='modal fade' id='m" . $s['id'] . "' tabindex='-1' aria-labelledby='m" . $s['id'] . "Label' aria-hidden='true'>
                    <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h5 class='modal-title' id='m" . $s['id'] . "Label'>" . Yii::t('app', 'Update') . "</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' id='contente" . $s['id'] . "'>
                        
                        </div>
                    </div>
                    </div>
                </div>
            </td>
        </tr>
        ";
    }
    $services .= "</tbody></table>";
    echo Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Maxsulotlar'),
                'content' => $products,
                'active' => true,
                'width' => "100%",
            ],
            [
                'label' => Yii::t('app', 'Xizmatlar'),
                'content' => $services,
            ],

        ],
    ]);
    ?>

</div>