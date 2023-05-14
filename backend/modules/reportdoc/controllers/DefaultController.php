<?php

namespace backend\modules\reportdoc\controllers;

use backend\models\Bases;
use backend\models\Contractors;
use backend\models\PayOffices;
use backend\models\Pricing;
use backend\models\Products;
use backend\models\Workers;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `reportdoc` module
 */
class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'fee' ) {
            $this->enableCsrfValidation = false;
        }
        //return true;
        return parent::beforeAction($action);
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $offices = PayOffices::find()->all();
        $productdoc = Products::getProductsForDoc();
        $bases = Bases::find()->all();
        $contractors = Contractors::find()->all();
        $workers = Workers::find()->all();
        return $this->render('index', [
            'offices'=>$offices,
            'productdoc'=>$productdoc,
            'bases'=>$bases,
            'contractors'=>$contractors,
            'workers'=>$workers,
        ]);
    }
    public function actionFee(){
        
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
        // masulotlar va ularga sarflangan ish haqlari hisoblanyapti
        $sql = "SELECT p.name_uz name_uz, p.name_ru name_ru, p.sale_price, SUM(pp.salary * pp.qty) all_salary FROM `production_proccess` pp 
        LEFT JOIN products p
        ON p.id = pp.product_id
        WHERE counted_at <= '{$to}' AND counted_at >= '{$from}'
        GROUP BY pp.product_id";
        $outlays = $this->getOutlaysByDate($from, $to);
        $products = Yii::$app->db->createCommand($sql)->queryAll();
        $firstPricing = $this->getFirstProductFee($outlays['summa'], $products);
        return $this->render('fee', [
            'products' => $products,
            'outlays' => $outlays,
            'from' => $from,
            'to' => $to,
        ]);
    }
    private function getOutlaysByDate($from, $to){
        $sql = "SELECT *FROM office_outlay oout
        WHERE date <= '{$to}' AND date >= '{$from}'";
        $outlays = Yii::$app->db->createCommand($sql)->queryAll();
        $b = [];
        $k = 0;
        $summ = 0;
        foreach($outlays as $o){
            $b[$k] = $o;
            if($o['exchange']==1){
                $b[$k]['amount'] *= $o['current_rate'];
            }
            $summ += $b[$k]['amount'];    
            $k++;
        }
        return [
            'array' => $b,
            'summa' => $summ
        ];
        
    }
    private function getFirstProductFee($summa, $products){
        $sql = "SELECT ps.*, ps.name_uz, ps.name_ru FROM pricing  p
        LEFT JOIN stages s
        ON s.id = p.stage_id
        LEFT JOIN products ps
        ON ps.id = p.product_id
        WHERE place = 1";
        $products = Yii::$app->db->createCommand($sql)->queryAll();
        echo "<pre>";
        print_r($products);
        echo "</pre>";
        exit();
        foreach($products as $p){

        }
    }
}
