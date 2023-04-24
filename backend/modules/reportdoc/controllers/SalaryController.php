<?php

namespace backend\modules\reportdoc\controllers;

use backend\models\RangeForm;
use Yii;

class SalaryController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'single-report' ) {
            $this->enableCsrfValidation = false;
        }
        //return true;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        $sql = "SELECT *from  workers w where earn <> 0";
        $model = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionSingleReport()
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'id mavjud emas'));
            $this->goBack();
        }
        $from = date("Y-m-1");
        $to = date("Y-m-d");
        if(!empty($_POST['date_range'])){
            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";
            // exit();
            $from = $_POST['from_date'];
            $to = $_POST['to_date'];
        }
        $to = date("Y-m-d", strtotime($to . "+1day"));
        $sql = "SELECT production_proccess.*, products.name_uz product FROM production_proccess left join products on products.id = production_proccess.product_id WHERE worker_id = {$id} AND counted_at <'{$to}' AND counted_at >='{$from}'";
        $model = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render(
            'single-report',
            [
                'from' => $from,
                'to' => $to,
                'model' => $model,
            ]
        );
    }
}
