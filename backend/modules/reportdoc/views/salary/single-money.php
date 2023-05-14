<?php

/** @var yii\web\View $this */

use kartik\daterange\DateRangePicker;

?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Oylik hisoblash') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'To`langan pullar') ?></li>
    </ol>

</div>
<!-- Page header end -->
<div class="main-container">
    <form method="POST" class="row">
        <div class="col-lg-4">
            <?

            $addon = <<< HTML
            <span class="input-group-text">
                <i class="icon-calendar1"></i>
            </span>
            HTML;
            echo '<div class="input-group drp-container">';
            echo DateRangePicker::widget([
                'name' => 'date_range',
                'id' => 'date_range',
                'value' => "{$from} - {$to}",
                'useWithAddon' => true,
                'convertFormat' => true,
                'startAttribute' => 'from_date',
                'endAttribute' => 'to_date',
                'pluginOptions' => [
                    'locale' => ['format' => 'Y-m-d'],
                ]
            ]) . $addon;
            echo '</div>';
            ?>
        </div>
        <div class="col-lg-4">
            <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Hisobotni shakllantirish') ?></button>
        </div>
    </form>
    <div class="row mt-3">
        <?
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        // exit;
        ?>
        <div class="table-responsive">
            <table class="table table-striped
            table-hover	
            align-middle">
                <thead class="table-light">
                    <caption><?= Yii::t('app', 'To`langan summalar hisoboti') ?></caption>
                    <tr>
                        <th><?= Yii::t('app', "Ishchi") ?></th>
                        <th><?= Yii::t('app', "Sana") ?></th>
                        <th><?= Yii::t('app', "Summa") ?></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <? foreach ($model as $m) : ?>
                        <tr class="table-secondary" style="border: 1px solid black;">
                            <td style="width: 25%;"><?= $m['full_name'] ?></td>
                            <td style="width: 20%;"><?= date("d.m.Y H:i", strtotime($m['date'])) ?></td>
                            <td style="text-align: right; width: 25%;"><?= number_format($m['cost_sum'], 0, ",", ' ') ?> <?= Yii::t('app', 'so`m') ?></td>
                        </tr>
                    <? endforeach ?>

                </tbody>
                <tfoot>
                    <tr class="table-secondary" style="border: 1px solid black;">
                        <td colspan="2">
                            <h4><?= Yii::t('app', 'Qoldiq summa:') ?></h4>
                        </td>
                        <td style="text-align: right; width: 25%;">
                            <h5><? if(!empty($m['earn'])) echo number_format($m['earn'], 0, ",", ' '); else echo 0; ?> <?= Yii::t('app', 'so`m') ?></h5>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>