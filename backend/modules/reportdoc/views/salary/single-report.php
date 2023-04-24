<?php

/** @var yii\web\View $this */

use kartik\daterange\DateRangePicker;

?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ishchilarni boshqarish') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Ishchilar ro`yxati') ?></li>
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
                    <caption><?= Yii::t('app', 'Ish haqlari hisoboti') ?></caption>
                    <tr>
                        <th><?= Yii::t('app', "Maxsulot") ?></th>
                        <th><?= Yii::t('app', "Chiqarilgan sana") ?></th>
                        <th><?= Yii::t('app', "Donasiga to`lanadigan summa") ?></th>
                        <th><?= Yii::t('app', "Soni") ?></th>
                        <th><?= Yii::t('app', "Brak") ?></th>
                        <th><?= Yii::t('app', "To`lanadigan umumiy summa") ?></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <? foreach ($model as $m) : ?>
                        <tr class="table-secondary" style="border: 1px solid black;">
                            <td style="width: 25%;"><?= $m['product'] ?></td>
                            <td style="width: 20%;"><?= date("d.m.Y", strtotime($m['counted_at'])) ?></td>
                            <td style="text-align: right; width: 25%;"><?= number_format($m['salary'], 0, ",", ' ') ?> <?= Yii::t('app', 'so`m') ?></td>
                            <td style="text-align: right; width: 5%;"><?= number_format($m['qty'], 0, ",", ' ') ?> <?= Yii::t('app', 'ta') ?></td>
                            <td style="text-align: right; width: 5%;"><?= number_format($m['invalid'], 0, ",", ' ') ?> <?= Yii::t('app', 'ta') ?></td>
                            <td style="text-align: right; width: 20%;"><?= number_format($m['qty'] * $m['salary'], 0, ",", ' ') ?> <?= Yii::t('app', 'so`m') ?></td>
                        </tr>
                    <? endforeach ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

    </div>
</div>