<?php

namespace backend\modules\reports\controllers;

use backend\models\Contractors;
use backend\models\ExchangeRates;
use backend\models\OfficeToOffice;
use backend\models\OfficeToOfficeSearch;
use backend\models\PayOffices;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfficeToOfficeController implements the CRUD actions for OfficeToOffice model.
 */
class OfficeToOfficeController extends Controller
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
     * Lists all OfficeToOffice models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OfficeToOfficeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OfficeToOffice model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OfficeToOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new OfficeToOffice();
        $offices = PayOffices::find()->asArray()->all();
        $rate = ExchangeRates::find()
        ->orderBy(['date'=>SORT_DESC])
        ->one();
        $model->current_rate = $rate->rate;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                //sanani togirlab olamiz
                if($model->date ==""){
                    $model->date = date("Y-m-d H:i");
                }else{
                    $model->date = date("Y-m-d H:i", strtotime($model->date));
                }
                $model->save();
                //kirim va chiqim kassani qarzlarini shu joydan tugirlab ketamiz
                $po =  PayOffices::findOne($model->debit_office);
                $contr = PayOffices::findOne($model->outlay_office);
                if($model->exchange){
                    $po->remains_usd += $model->amount;
                    if($model->exchange_sum != ""){
                        $contr->remains_sum -= $model->exchange_sum;
                    }else{
                        $contr->remains_usd -= $model->amount;
                    }
                }else{
                    $po->remains_sum += $model->amount;
                    if($model->exchange_sum != ""){
                        $contr->remains_usd -= $model->exchange_sum;
                    }else{
                        $contr->remains_sum -= $model->amount;
                    }
                }
                $po->save();
                $contr->save();

                // echo "<pre>";
                // print_r($model);
                // echo "</pre>";
                // echo date("Y-m-d H:i", strtotime($model->date));
                // exit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'offices' => $offices,
        ]);
    }

    /**
     * Updates an existing OfficeToOffice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $offices = PayOffices::find()->asArray()->all();
        $contractors = Contractors::find()->all();
        $oldoffice_id = $model->debit_office;
        $oldcontractor_id = $model->outlay_office;
        $oldamount = $model->amount;
        $oldexchange = $model->exchange;
        $oldexchange_sum = $model->exchange_sum;

        if ($model->load($this->request->post())) {
            //eski xolatlarni togirlash
            $opo = PayOffices::findOne($oldoffice_id);
            $ocontr = PayOffices::findOne($oldcontractor_id);
            if($oldexchange){
                $opo->remains_usd -= $oldamount;
                if($oldexchange_sum != ""){
                    $ocontr->remains_sum += $oldexchange_sum;
                }else{
                    $ocontr->remains_usd += $oldamount;
                }
            }else{
                $opo->remains_sum -= $oldamount;
                if($oldexchange_sum != ""){
                    $ocontr->remains_usd += $oldexchange_sum;
                }else{
                    $ocontr->remains_sum += $oldamount;
                }
            }
            $opo->save();
            $ocontr->save();
            //sanani togirlab olamiz
            $model->date = date("Y-m-d H:i", strtotime($model->date));
            $model->save();
            //kassani va kontragentni qarzlarini shu joydan tugirlab ketamiz
            $po =  PayOffices::findOne($model->debit_office);
            $contr = PayOffices::findOne($model->outlay_office);
            if($model->exchange){
                $po->remains_usd += $model->amount;
                if($model->exchange_sum != ""){
                    $contr->remains_sum -= $model->exchange_sum;
                }else{
                    $contr->remains_usd -= $model->amount;
                }
            }else{
                $po->remains_sum += $model->amount;
                if($model->exchange_sum != ""){
                    $contr->remains_usd -= $model->exchange_sum;
                }else{
                    $contr->remains_sum -= $model->amount;
                }
            }
            $po->save();
            $contr->save();

            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // echo date("Y-m-d H:i", strtotime($model->date));
            // exit();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'offices' => $offices,
            'contractors'=>$contractors,
        ]);
    }

    /**
     * Deletes an existing OfficeToOffice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldoffice_id = $model->debit_office;
        $oldcontractor_id = $model->outlay_office;
        $oldamount = $model->amount;
        $oldexchange = $model->exchange;
        $oldexchange_sum = $model->exchange_sum;
        //eski xolatlarni togirlash
        $opo = PayOffices::findOne($oldoffice_id);
        $ocontr = PayOffices::findOne($oldcontractor_id);
        if($oldexchange){
            $opo->remains_usd -= $oldamount;
            if($oldexchange_sum != ""){
                $ocontr->remains_sum += $oldexchange_sum;
            }else{
                $ocontr->remains_usd += $oldamount;
            }
        }else{
            $opo->remains_sum -= $oldamount;
            if($oldexchange_sum != ""){
                $ocontr->remains_usd += $oldexchange_sum;
            }else{
                $ocontr->remains_sum += $oldamount;
            }
        }
        $opo->save();
        $ocontr->save();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OfficeToOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OfficeToOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OfficeToOffice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
