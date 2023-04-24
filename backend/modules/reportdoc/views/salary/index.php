<?php

/** @var yii\web\View $this */

use kartik\daterange\DateRangePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Dropdown;

?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ishchilarni boshqarish') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Oyliklar') ?></li>
    </ol>

</div>
<!-- Page header end -->
<div class="main-container">
    <div class="row">
        <div class="col-lg-4">
            <?

            $addon = <<< HTML
            <span class="input-group-text">
                <i class="icon-calendar1"></i>
            </span>
            HTML;
            // echo '<div class="input-group drp-container">';
            // echo DateRangePicker::widget([
            //     'name' => 'date_range',
            //     'id' => 'date_range',
            //     'value' => "{$from} - {$to}",
            //     'useWithAddon' => true,
            //     'convertFormat' => true,
            //     'startAttribute' => 'from_date',
            //     'endAttribute' => 'to_date',
            //     'pluginOptions' => [
            //         'locale' => ['format' => 'Y-m-d'],
            //     ]
            // ]) . $addon;
            // echo '</div>';
            ?>
        </div>
        <div class="col-lg-4">
            <!-- <button type="button" onclick="getReport(document.getElementById('date_range'))" class="btn btn-primary"><?= Yii::t('app', 'Hisobotni shakllantirish') ?></button> -->
        </div>
    </div>
    <div class="row mt-3">
        <?
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        ?>
        <div class="table-responsive">
            <table class="table table-striped
            table-hover	
            table-borderless
            align-middle">
                <thead class="table-light">
                    <caption><?= Yii::t('app', 'Ish haqlari hisoboti') ?></caption>
                    <tr>
                        <th><?= Yii::t('app', "Ishchi") ?></th>
                        <th><?= Yii::t('app', "Ish haqi") ?></th>
                        <th><?= Yii::t('app', "Jarayon") ?></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <? foreach ($model as $m) : ?>
                        <tr class="table-secondary">
                            <td><?= $m['full_name'] ?></td>
                            <td><?= number_format($m['earn'], 0, ",", ' ') ?> <?= Yii::t('app', 'so`m') ?></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-outline-info"><?=Yii::t('app', 'Tanlang')?> <b class="caret"></b></a>
                                    <?php
                                    echo Dropdown::widget([
                                        'items' => [
                                            ['label' => Yii::t('app', "Yakkalik hisobot"), 'url' => '/reportdoc/salary/single-report?id='.$m['id']],
                                            ['label' => 'DropdownB', 'url' => '#'],
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <? endforeach ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

    </div>
</div>

<script>
    function getReport(obj) {
        alert(obj.value)
    }
</script>