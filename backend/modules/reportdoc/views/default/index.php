<?php
function isNotNull($num){
    if($num == null) return 0;
    return $num;
}
use yii\bootstrap5\Tabs;
$this->title = Yii::t('app', 'Hisobxona');
$this->params['breadcrumbs'][] = $this->title;
$officesContent = "
    <table class='table table-bordered table-striped table-success mb-5 w-100'>
    <tr>
        <th>#</th>
        <th>" . Yii::t('app', 'Kassa') . "</th>
        <th>" . Yii::t('app', 'So`m') . "</th>
        <th>" . Yii::t('app', 'Dollar') . "</th>
    </tr>
";
$amountSum = 0;
$amountUsd = 0;
foreach ($offices as $o) :
    $officesContent .= "<tr class='p-0'>";
    $officesContent .= "<td class='p-0'>{$o->id}</td>";
    $officesContent .= "<td class='p-0'>{$o->name}</td>";
    $officesContent .= "<td class='p-0'><p class='float-end'>" . number_format(isNotNull($o->remains_sum), 2, '.', ' ') . "</p></td>";
    $officesContent .= "<td class='p-0'><p class='float-end'>" . number_format(isNotNull($o->remains_usd), 2, '.', ' ') . "</p></td>";
    $amountSum += $o->remains_sum;
    $amountUsd += $o->remains_usd;
    $officesContent .= "</tr>";
endforeach;
$officesContent .= "
        <tr class='py-0'>    
            <th colspan='2' class='text-center h3'>" . Yii::t('app', 'Jami') . "</th>    
            <th><p class='float-end'>" . number_format($amountSum, 2, '.', ' ') . "</p></th>    
            <th><p class='float-end'>" . number_format($amountUsd, 2, '.', ' ') . "</p></th>
        </tr>    
    </table>
";
// $amountSum = 0;
// $amountUsd = 0;
$productsContent = "";
foreach ($bases as $b) :
    $i = 1;
    $productsContent .= "<table class='table table-bordered table-striped table-success mb-5 w-100'>
    <tr>
    <td></td>
    <td colspan='4'><h2 class='text-center'>{$b->name_uz}</h2></td>
    </tr>";
    $productsContent .= "
        <tr class='py-0'>
            <th>#</th>
            <th>" . Yii::t('app', 'Maxsulot') . "</th>
            <th>" . Yii::t('app', 'Omborda') . "</th>
            <th colspan='2'>" . Yii::t('app', 'Tannarxida') . "</th>
        </tr>
    ";
    foreach ($productdoc as $o) :
        if ($b->id == $o['base']) :
            $productsContent .= "<tr class='py-0'>";
            $productsContent .= "<td class='py-0'>" . $i . "</td>";
            $i++;
            $productsContent .= "<td class='py-0'>" . $o['product'] . "</td>";
            $productsContent .= "<td class='py-0'><p class='float-end'>" . number_format(isNotNull($o['remains']), 2, '.', ' ') . "</p></td>";
            $productsContent .= "<td class='py-0'><p class='float-end'>" . number_format(isNotNull($o['fee']), 2, '.', ' ') . "</p></td>";
            $productsContent .= "<td class='py-0'><p class='float-end'>" . number_format(isNotNull($o['fee'] * $o['remains']), 2, '.', ' ') . "</p></td>";
            // $amountSum += $o->remains_sum;
            // $amountUsd += $o->remains_usd;
            $productsContent .= "</tr>";
        endif;
    endforeach;
    $productsContent .= "   
        </table>
    ";
endforeach;

$suplierContent = "
    <table class='table table-bordered w-100'>
    <tr>
        <th colspan='3'>&nbsp;</th>
        <th colspan='2'>" . Yii::t('app', 'So`m') . "</th>
        <th colspan='2'>" . Yii::t('app', 'Dollar') . "</th>
    </tr>
    <tr class='py-0'>
        <th>#</th>
        <th>" . Yii::t('app', 'Xaridor') . "</th>
        <th>" . Yii::t('app', 'Tel') . "</th>
        <th>" . Yii::t('app', 'Xaqqi') . "</th>
        <th>" . Yii::t('app', 'Qarzi') . "</th>
        <th>" . Yii::t('app', 'Xaqqi') . "</th>
        <th>" . Yii::t('app', 'Qarzi') . "</th>
    </tr>
";
$amountDebtSum = 0;
$amountCostSum = 0;
$amountDebtUsd = 0;
$amountCostUsd = 0;
foreach ($contractors as $o) :
    if ($o->type_id == 1) :
        if ($o->debt_sum >= 0) {
            $debtSum = $o->debt_sum;
        } else {
            $debtSum = 0;
        }
        if ($o->debt_sum <= 0) {
            $costSum = -1 * $o->debt_sum;
        } else {
            $costSum = 0;
        }
        if ($o->debt_usd >= 0) {
            $debtUsd = $o->debt_usd;
        } else {
            $debtUsd = 0;
        }
        if ($o->debt_usd <= 0) {
            $costUsd = -1 * $o->debt_usd;
        } else {
            $costUsd = 0;
        }

        $suplierContent .= "<tr class='py-0'>";
        $suplierContent .= "<td class='py-0'>{$o->id}</td>";
        $suplierContent .= "<td class='py-0'>{$o->name}</td>";
        $suplierContent .= "<td class='py-0'>{$o->tel}</td>";
        $suplierContent .= "<td class='py-0'><p class='float-end'>" . number_format($debtSum, 2, '.', ' ') . "</p></td>";
        $suplierContent .= "<td class='py-0'><p class='float-end'>" . number_format($costSum, 2, '.', ' ') . "</p></td>";
        $suplierContent .= "<td class='py-0'><p class='float-end'>" . number_format($debtUsd, 2, '.', ' ') . "</p></td>";
        $suplierContent .= "<td class='py-0'><p class='float-end'>" . number_format($costUsd, 2, '.', ' ') . "</p></td>";
        $amountDebtSum += $debtSum;
        $amountCostSum += $costSum;
        $amountDebtUsd += $debtUsd;
        $amountCostUsd += $costUsd;
        $suplierContent .= "</tr>";
    endif;
endforeach;
$suplierContent .= "
        <tr class='py-0'>    
            <th colspan='3' class='text-center h3'>" . Yii::t('app', 'Jami') . "</th>    
            <th><p class='float-end'>" . number_format($amountDebtSum, 2, '.', ' ') . "</p></th>
            <th><p class='float-end'>" . number_format($amountCostSum, 2, '.', ' ') . "</p></th>
            <th><p class='float-end'>" . number_format($amountDebtUsd, 2, '.', ' ') . "</p></th>
            <th><p class='float-end'>" . number_format($amountCostUsd, 2, '.', ' ') . "</p></th>
        </tr>    
    </table>
";

$customerContent = "
    <table class='table table-bordered w-100'>
    <tr>
        <th colspan='3'>&nbsp;</th>
        <th colspan='2'>" . Yii::t('app', 'So`m') . "</th>
        <th colspan='2'>" . Yii::t('app', 'Dollar') . "</th>
    </tr>
    <tr class='py-0'>
        <th>#</th>
        <th>" . Yii::t('app', 'Xaridor') . "</th>
        <th>" . Yii::t('app', 'Tel') . "</th>
        <th>" . Yii::t('app', 'Xaqqi') . "</th>
        <th>" . Yii::t('app', 'Qarzi') . "</th>
        <th>" . Yii::t('app', 'Xaqqi') . "</th>
        <th>" . Yii::t('app', 'Qarzi') . "</th>
    </tr>
";
$amountDebtSum = 0;
$amountCostSum = 0;
$amountDebtUsd = 0;
$amountCostUsd = 0;
foreach ($contractors as $o) :
    if ($o->type_id == 2) :
        if ($o->debt_sum >= 0) {
            $debtSum = $o->debt_sum;
        } else {
            $debtSum = 0;
        }
        if ($o->debt_sum <= 0) {
            $costSum = -1 * $o->debt_sum;
        } else {
            $costSum = 0;
        }
        if ($o->debt_usd >= 0) {
            $debtUsd = $o->debt_usd;
        } else {
            $debtUsd = 0;
        }
        if ($o->debt_usd <= 0) {
            $costUsd = -1 * $o->debt_usd;
        } else {
            $costUsd = 0;
        }

        $customerContent .= "<tr class='py-0'>";
        $customerContent .= "<td class='py-0'>{$o->id}</td>";
        $customerContent .= "<td class='py-0'>{$o->name}</td>";
        $customerContent .= "<td class='py-0'>{$o->tel}</td>";
        $customerContent .= "<td class='py-0'><p class='float-end'>" . number_format($debtSum, 2, '.', ' ') . "</p></td>";
        $customerContent .= "<td class='py-0'><p class='float-end'>" . number_format($costSum, 2, '.', ' ') . "</p></td>";
        $customerContent .= "<td class='py-0'><p class='float-end'>" . number_format($debtUsd, 2, '.', ' ') . "</p></td>";
        $customerContent .= "<td class='py-0'><p class='float-end'>" . number_format($costUsd, 2, '.', ' ') . "</p></td>";
        $amountDebtSum += $debtSum;
        $amountCostSum += $costSum;
        $amountDebtUsd += $debtUsd;
        $amountCostUsd += $costUsd;
        $customerContent .= "</tr>";
    endif;
endforeach;

?>
<h3 class="text-end text-muted"><?= date("d.m.Y") ?></h3>
<?
echo Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Pul mablag`lari'),
            'content' => $officesContent,
            'active' => true
        ],
        [
            'label' => Yii::t('app', 'Tovarlar'),
            'content' => $productsContent,
        ]
    ],
]);
?>