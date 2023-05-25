<?
use kartik\daterange\DateRangePicker;
function getFeeById($id, $array){
    foreach($array as $a){
        if($a['id']==$id){
            return $a['fee'];
        }
    }
    return 0;
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Hisobotlar') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Tannarx') ?></li>
    </ol>

</div>
<!-- Page header end -->
<div class="main-container">
    <form method="POST" class="row mb-5">
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
    <div class="d-grid gap-2 mb-3">
        <button type="button" name="" id="" class="btn btn-info btn-lg"><?= Yii::t('app', 'Tannarxlarni ishlash') ?></button>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <h3><a href="/reports/office-outlay/"><?=Yii::t('app', 'Shu oraliqda qilingan chiqimlar')?></a> : <? if($outlays['summa']!="") echo number_format($outlays['summa'], 0, ",", ' '); else echo 0; ?> <?=Yii::t('app', 'so`m')?></h3>
                </tr>
                <thead>
                    <tr>
                        <th><?=Yii::t('app', 'Maxsulot')?></th>
                        <th><?=Yii::t('app', 'Tannarxi')?></th>
                        <th><?=Yii::t('app', 'Oylikka sarflangan summa')?></th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($products as $p) : ?>
                        <tr>
                            <td><?= $p['name_' . Yii::$app->language] ?></td>
                            <? $thisFee = getFeeById($p['id'], $fee); ?>
                            <td><input type="number" value="<? if($thisFee != 0){
                                echo round($thisFee);
                            }else{
                                echo $p['sale_price'];
                            } ?>"></td>
                            <td><?= $p['all_salary'] ?> <?=Yii::t('app', 'so`m')?></td>
                        </tr>
                    <? endforeach ?>
                </tbody>
            </table>
        </div>

    </div>
</div>