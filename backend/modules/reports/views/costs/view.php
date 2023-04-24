<?php

use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Costs */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/backend/web/js/costs-proccess.js');
?>
<div class="costs-view">

    <p>
        <?= Html::a(Yii::t('app', 'Close'), ['/'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'office_id',
                'value'=>function($data){
                    return $data->office->name;
                }
            ],
            // 'user_id',
            [
                'attribute'=>'user_id',
                'value'=>function($data){
                    return $data->user->username;
                }
            ],
            // 'remains_sum',
            // 'cost_sum',
            [
                'attribute'=>'cost_sum',
                'format'=>'raw',
                'value'=>function($data){
                    $amount = number_format($data->cost_sum, 0, ',', ' ');
                    return "<p>{$amount}"." ".Yii::t('app', 'so`m')."</p>";
                }
            ],
            // 'remains_usd',
            // 'cost_usd',
            [
                'attribute'=>'cost_usd',
                'format'=>'raw',
                'value'=>function($data){
                    $amount = number_format($data->cost_usd, 0, ',', ' ');
                    return "<p>{$amount}"." ".Yii::t('app', 'dollar')."</p>";
                }
            ],
            // 'date',
            [
                'attribute'=>'date',
                'value'=>function($data){
                    return date("d/m/Y", strtotime($data->date));
                }
            ],
        ],
    ]) ?>
    <?
    $salaries = "
    <table class='table table-hover table-inverse table-responsive'>
        <thead class='thead-inverse'>
            <tr>
                <th>".Yii::t('app', 'Ishchi')."</th>
                <th>".Yii::t('app', 'Izoh')."</th>
                <th>".Yii::t('app', 'So`mda')."</th>
                <th>".Yii::t('app', 'Dollarda')."</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
    ";
    foreach($model->salary as $s){
        $salaries .= "
        <tr>
            <td>".$s['worker']."</td>
            <td>".$s['comment']."</td>
            <td>".number_format($s['cost_sum'], 0, '.', ' ')." ".Yii::t('app', 'so`m')."</td>
            <td>".number_format($s['cost_usd'], 0, '.', ' ')." ".Yii::t('app', 'dollar')."</td>
            <td>
                <button type='button' class='btn btn-primary' onclick='getModelSalary(".$s['id'].")' data-bs-toggle='modal' data-bs-target='#m".$s['id']."'>
                    <i class='icon-pencil'></i>
                </button>
                <a class='btn btn-danger' href='/reports/costs/delete-salary?id=".$s['id']."'>
                    <i class='icon-trash'></i>
                </a>
                <div class='modal fade' id='m".$s['id']."' tabindex='-1' aria-labelledby='m".$s['id']."Label' aria-hidden='true'>
                    <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h5 class='modal-title' id='m".$s['id']."Label'>".Yii::t('app', 'Update')."</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' id='content".$s['id']."'>
                        
                        </div>
                    </div>
                    </div>
                </div>
          </td>
        </tr>
        ";
    }
    $salaries .= "</tbody></table>";
    echo Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Ish xaqi'),
                'content' => $salaries,
                'active' => true,
                'width'=>"100%",
            ]
            
        ],
    ]);
    ?>

</div>