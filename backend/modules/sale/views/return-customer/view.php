<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ReturnCustomer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJsFile('/js/sale-rc-update.js');
?>
<div class="return-Customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Close'), ['/'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
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
                    if ($data->base_id != "") return $data->base->name;
                }
            ],
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->user_id != "") return $data->user->username;
                }
            ],
            'amount_sum',
            'amount_usd',
            'date',
            // 'special',
            // 'status',
        ],
    ]) ?>
    <?
    $special = "
        <table class='table table-hover table-inverse table-responsive'>
            <thead class='thead-inverse'>
                <tr>
                    <th>" . Yii::t('app', 'Maxsulot') . "</th>
                    <th>" . Yii::t('app', 'Miqdor') . "</th>
                    <th>" . Yii::t('app', 'Narx') . "</th>
                    <th>" . Yii::t('app', 'QQS stavkasi') . "</th>
                    <th>" . Yii::t('app', 'Summa') . "</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
        ";
    foreach ($myspecial as $s) {
        if (!$s['exchange']) {
            $btn = 'info';
            $text = Yii::t('app', 'so`m');
        } else {
            $btn = 'primary';
            $text = Yii::t('app', 'dollar');
        }
        $confirm = Yii::t('app', 'Siz rostdan ham ushbu elementni o`chirmoqchimisiz?');
        $special .= "
            <tr>
                <td>" . $s['product'] . "</td>
                <td>" . number_format($s['qty'], 0, '.', ' ') . ' ' . $s['value'] . "</td>
                <td>" . number_format($s['price'], 2, '.', ' ') . " " . $text . "</td>
                <td>" . $s['vat_bet'] . "%</td>
                <td>" . number_format($s['amount_with_vat'], 2, '.', ' ') . " " . $text . "</td>
                <td>
                    <button type='button' class='btn btn-primary' onclick='getModel(" . $s['id'] . ")' data-bs-toggle='modal' data-bs-target='#m" . $s['id'] . "'>
                        <i class='fa fa-pen'></i>
                    </button>
                    <a class='btn btn-danger' data-method='post' data-confirm='{$confirm}' href='/sale/return-customer/delete-item?id=" . $s['id'] . "'>
                        <i class='fa fa-trash'></i>
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
    $special .= "</tbody></table>";
    echo $special;
    ?>
</div>