<?php

namespace backend\modules\sale\controllers;

use backend\models\BaseIncome;
use backend\models\BaseRemains;
use backend\models\Bases;
use backend\models\Contractors;
use backend\models\ExchangeRates;
use backend\models\PayOffices;
use backend\models\Products;
use backend\models\ProductSale;
use backend\models\ProductSaleSearch;
use backend\models\PsProducts;
use backend\models\PsServices;
use backend\models\Services;
use backend\models\User;
use backend\models\Workers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * ProductSaleController implements the CRUD actions for ProductSale model.
 */
class ProductSaleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ProductSale models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSaleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $contractors = ArrayHelper::map(Contractors::find()->all(), 'id', 'name');
        $bases = ArrayHelper::map(Bases::find()->all(), 'id', 'name');
        $offices = ArrayHelper::map(PayOffices::find()->all(), 'id', 'name');
        $users = ArrayHelper::map(User::find()->all(), 'id', 'username');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bases' => $bases,
            'offices' => $offices,
            'users' => $users,
            'contractors' => $contractors,
        ]);
    }

    /**
     * Displays a single ProductSale model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->products = ProductSale::getSaledProducts($id);
        $model->services = ProductSale::getSaledServices($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }
    public function actionUpdateProduct($id, $base){
        $model = PsProducts::findOne($id);
        $products = ArrayHelper::map(Products::find()->all(), 'id', 'name');
        if($this->request->isPost) {
            BaseIncome::addQtyByFIFO($base, $model->product_id, $model->qty);
            BaseIncome::removeQtyByFIFO($base, $_POST['PsProducts']['product_id'], $_POST['PsProducts']['qty']);
            // echo "<pre>";
            // print_r($_POST);
            // print_r($model);
            // echo "</pre>";
            // exit();
            $ps = ProductSale::findOne($model->ps_id);
            //eskilarni togirlash
            BaseRemains::addQty($base, $model->product_id, $model->qty);
            //yangi qoldiq
            BaseRemains::removeQty($base, $_POST['PsProducts']['product_id'], $_POST['PsProducts']['qty']);
            //pullar eski
            $oldAmount = $model->amount;
            if($model->exchange==1){
                $oldAmount = $model->amount * $ps->current_rate;
            }

            //pullar yangi
            $newAmount = $_POST['PsProducts']['amount'];
            if($_POST['PsProducts']['exchange']==1){
                $newAmount = $_POST['PsProducts']['amount'] * $ps->current_rate;
            }

            $diff = $oldAmount - $newAmount;
            if($ps->exchange_amount==1){
                $ps->amount -= $diff;
            }else{
                $ps->amount -= $diff/$ps->current_rate;
            }
            if($ps->exchange_amount==1){
                $cost_sum_contr = $diff;
                $contr = [
                    'contractor_id'=>$ps->contractor_id,
                    'cost_sum'=>$cost_sum_contr,
                    'cost_usd'=>0
                ];
                Contractors::removeRemains($contr);
            }else{
                $cost_usd_contr = $diff/$ps->current_rate;
                $contr = [
                    'contractor_id'=>$ps->contractor_id,
                    'cost_usd'=>$cost_usd_contr,
                    'cost_sum'=>0
                ];
                Contractors::removeRemains($contr);
            }
            
            $model->product_id = $_POST['PsProducts']['product_id'];
            $model->amount = $_POST['PsProducts']['amount'];
            $model->volume = $_POST['PsProducts']['volume'];
            $model->exchange = $_POST['PsProducts']['exchange'];
            $model->price = $_POST['PsProducts']['price'];
            $model->qty = $_POST['PsProducts']['qty'];
            $model->fee = $_POST['PsProducts']['fee'];
            $model->special = $_POST['PsProducts']['special'];
            $model->save();
            $ps->save();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Muvaffaqiyatli saqlandi!'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update-product', [
            'model'=>$model,
            'products'=>$products,
            'base'=>$base,
        ]);
    }
    public function actionUpdateService($id){
        $model = PsServices::findOne($id);
        $services = ArrayHelper::map(Services::find()->all(), 'id', 'name');
        $workers = ArrayHelper::map(Workers::find()->all(), 'id', 'name');
        if($this->request->isPost) {
            $ps = ProductSale::findOne($model->ps_id);
            $oldAmount = $model->amount;
            $newAmount = $_POST['PsServices']['amount'];
            $diff = $oldAmount - $newAmount;
            if($ps->exchange_amount==1){
                $ps->amount -= $diff;
            }else{
                $ps->amount -= $diff/$ps->current_rate;
            }
            if($ps->exchange_amount==1){
                $cost_sum_contr = $diff;
                $contr = [
                    'contractor_id'=>$ps->contractor_id,
                    'cost_sum'=>$cost_sum_contr,
                    'cost_usd'=>0
                ];
                Contractors::removeRemains($contr);
            }else{
                $cost_usd_contr = $diff/$ps->current_rate;
                $contr = [
                    'contractor_id'=>$ps->contractor_id,
                    'cost_usd'=>$cost_usd_contr,
                    'cost_sum'=>0
                ];
                Contractors::removeRemains($contr);
            }
            //eski ishchini togirlash
            $remains = [
                'worker_id'=>$model->worker_id,
                'cost_sum'=>$model->amount,
                'cost_usd'=>0,
            ];
            Workers::removeRemains($remains);
            //yangi ishchiga  haq
            $remains = [
                'worker_id'=>$_POST['PsServices']['worker_id'],
                'cost_sum'=>$_POST['PsServices']['amount'],
                'cost_usd'=>0,
            ];
            Workers::addRemains($remains);
            $model->worker_id = $_POST['PsServices']['worker_id'];
            $model->comment = $_POST['PsServices']['comment'];
            $model->amount = $_POST['PsServices']['amount'];
            $model->service_id = $_POST['PsServices']['service_id'];
            $model->save();
            $ps->save();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Muvaffaqiyatli saqlandi!'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update-service', [
            'model'=>$model,
            'services'=>$services,
            'workers'=>$workers,
        ]);
    }
    public function actionDeleteService($id){
        $model = PsServices::findOne($id);
        $ps = ProductSale::findOne($model->ps_id);
            $oldAmount = $model->amount;
            $newAmount = 0;
            $diff = $oldAmount - $newAmount;
            if($ps->exchange_amount==1){
                $ps->amount -= $diff;
            }else{
                $ps->amount -= $diff/$ps->current_rate;
            }
            if($ps->exchange_amount==1){
                $cost_sum_contr = $diff;
                $contr = [
                    'contractor_id'=>$ps->contractor_id,
                    'cost_sum'=>$cost_sum_contr,
                    'cost_usd'=>0
                ];
                Contractors::removeRemains($contr);
            }else{
                $cost_usd_contr = $diff/$ps->current_rate;
                $contr = [
                    'contractor_id'=>$ps->contractor_id,
                    'cost_usd'=>$cost_usd_contr,
                    'cost_sum'=>0
                ];
                Contractors::removeRemains($contr);
            }
            //eski ishchini togirlash
            $remains = [
                'worker_id'=>$model->worker_id,
                'cost_sum'=>$model->amount,
                'cost_usd'=>0,
            ];
            Workers::removeRemains($remains);
            $model->delete();
            $ps->save();
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Element o`chirildi!'));
            return $this->redirect(Yii::$app->request->referrer);

    }
    public function actionDeleteProduct($id, $base){
        $model = PsProducts::findOne($id);
        $ps = ProductSale::findOne($model->ps_id);
        //eskilarni togirlash
        BaseRemains::addQty($base, $model->product_id, $model->qty);
        //pullar eski
        $oldAmount = $model->amount;
        if($model->exchange==1){
            $oldAmount = $model->amount * $ps->current_rate;
        }

        //pullar yangi
        $newAmount = 0;

        $diff = $oldAmount - $newAmount;
        if($ps->exchange_amount==1){
            $ps->amount -= $diff;
        }else{
            $ps->amount -= $diff/$ps->current_rate;
        }
        if($ps->exchange_amount==1){
            $cost_sum_contr = $diff;
            $contr = [
                'contractor_id'=>$ps->contractor_id,
                'cost_sum'=>$cost_sum_contr,
                'cost_usd'=>0
            ];
            Contractors::removeRemains($contr);
        }else{
            $cost_usd_contr = $diff/$ps->current_rate;
            $contr = [
                'contractor_id'=>$ps->contractor_id,
                'cost_usd'=>$cost_usd_contr,
                'cost_sum'=>0
            ];
            Contractors::removeRemains($contr);
        }
        $model->delete();
        $ps->save();
        Yii::$app->session->setFlash('warning', Yii::t('app', 'Element o`chirildi!'));
        return $this->redirect(Yii::$app->request->referrer);

    }
    /**
     * Creates a new ProductSale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductSale();
        $products = ArrayHelper::map(Products::find()->all(), 'id', 'name_uz');
        $workers = ArrayHelper::map(Workers::find()->all(), 'id', 'fio');
        $services = ArrayHelper::map(Services::find()->all(), 'id', 'name');
        $office = ArrayHelper::map(PayOffices::find()->all(), 'id', 'name');
        $base = ArrayHelper::map(Bases::find()->all(), 'id', 'name_uz');
        $contractors = ArrayHelper::map(Contractors::find()->all(), 'id', 'name');
        $model->base_id = 3;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                //sanani togirlab olamiz
                if($model->date ==""){
                    $model->date = date("Y-m-d");
                }else{
                    $model->date = date("Y-m-d", strtotime($model->date));
                }
                $products = $model->products;
                $services = $model->services;
                $model->products = null;
                $model->services = null;
                $model->user_id = Yii::$app->user->id;
                // echo "<pre>";
                // print_r($model->attributes);
                // // print_r($products);
                // echo "</pre>";
                // exit();
                $model->save();
                foreach($products as $p):
                    if($p['product_id']!=""){
                        $fifo = BaseIncome::removeQtyByFIFO($model->base_id, $p['product_id'], $p['qty']);
                        if(!$fifo){
                            break;
                        }
                        $pr = new PsProducts();
                        $pr->ps_id = $model->id;
                        $pr->product_id = $p['product_id'];
                        $pr->volume = $p['volume'];
                        $pr->exchange = $p['exchange'];
                        $pr->qty = $p['qty'];
                        $pr->price = $p['price'];
                        $pr->amount = $p['amount'];
                        $pr->fee = $p['fee'];
                        $pr->special = $p['special'];
                        $pr->save();
                        BaseRemains::removeQty($model->base_id, $p['product_id'], $p['qty']);
                    }
                endforeach;
                foreach($services as $s):
                    if($s['worker_id']!=""){
                        $se = new PsServices();
                        $se->ps_id = $model->id;
                        $se->worker_id = $s['worker_id'];
                        $se->service_id = $s['service_id'];
                        $se->amount = $s['amount'];
                        $se->comment = $s['comment'];
                        $se->save();
                        $remains = [
                            'worker_id'=>$se->worker_id,
                            'cost_sum'=>$se->amount,
                            'cost_usd'=>0,
                        ];
                        Workers::addRemains($remains);
                    }
                endforeach;
                Yii::$app->session->setFlash('success', Yii::t('app', 'Muvaffaqiyatli saqlandi!'));
                if($model->convertme&&$model->exchange_amount==1){
                    $cost_usd_kassa = $model->amount_convert;
                    $cost_sum_contr = $model->amount-$model->amount_convert*$model->current_rate;
                    $contr = [
                        'contractor_id'=>$model->contractor_id,
                        'cost_sum'=>$cost_sum_contr,
                        'cost_usd'=>0
                    ];
                    Contractors::addRemains($contr);
                    $office = [
                        'office_id'=>$model->office_id,
                        'cost_sum'=> 0,
                        'cost_usd'=>$cost_usd_kassa
                    ];
                    PayOffices::addRemains($office);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                if($model->convertme&&$model->exchange_amount==2){
                    $cost_sum_kassa = $model->amount_convert;
                    $cost_usd_contr = $model->amount-$model->amount_convert/$model->current_rate;
                    $contr = [
                        'contractor_id'=>$model->contractor_id,
                        'cost_usd'=>$cost_usd_contr,
                        'cost_sum'=>0
                    ];
                    Contractors::addRemains($contr);
                    $office = [
                        'office_id'=>$model->office_id,
                        'cost_usd'=> 0,
                        'cost_sum'=>$cost_sum_kassa
                    ];
                    PayOffices::addRemains($office);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                if(!$model->convertme&&$model->exchange_amount==1){
                    $cost_sum_kassa = $model->amount_convert;
                    $cost_sum_contr = $model->amount-$model->amount_convert;
                    $contr = [
                        'contractor_id'=>$model->contractor_id,
                        'cost_sum'=>$cost_sum_contr,
                        'cost_usd'=>0
                    ];
                    Contractors::addRemains($contr);
                    $office = [
                        'office_id'=>$model->office_id,
                        'cost_usd'=> 0,
                        'cost_sum'=>$cost_sum_kassa
                    ];
                    PayOffices::addRemains($office);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                if(!$model->convertme&&$model->exchange_amount==2){
                    $cost_usd_kassa = $model->amount_convert;
                    $cost_usd_contr = $model->amount-$model->amount_convert;
                    $contr = [
                        'contractor_id'=>$model->contractor_id,
                        'cost_usd'=>$cost_usd_contr,
                        'cost_sum'=>0
                    ];
                    Contractors::addRemains($contr);
                    $office = [
                        'office_id'=>$model->office_id,
                        'cost_sum'=> 0,
                        'cost_usd'=>$cost_usd_kassa
                    ];
                    PayOffices::addRemains($office);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                // echo "<pre>";
                // print_r($model);
                // print_r($model->services);
                // echo "</pre>";
                // exit();
            }
        } else {
            $model->current_rate = ExchangeRates::getRateByDate(date('Y-m-d'));
            $model->date = date("d-m-Y");
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
            'workers' => $workers,
            'services' => $services,
            'office' => $office,
            'base' => $base,
            'contractors' => $contractors,
        ]);
    }
    public function actionGetAttributes($id, $base){
        $volume = ProductSale::getProductAttributes($id, $base);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $volume;
    }

    /**
     * Updates an existing ProductSale model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing ProductSale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the ProductSale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductSale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSale::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
