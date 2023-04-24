<?php

namespace backend\modules\base\controllers;

use backend\models\BaseIncome;
use backend\models\BaseRemains;
use backend\models\Bases;
use backend\models\BasesSearch;
use backend\models\Contractors;
use backend\models\ExchangeRates;
use backend\models\PiItems;
use backend\models\Products;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BaseController implements the CRUD actions for Bases model.
 */
class BaseController extends Controller
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
     * Lists all Bases models.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('../base');
    }

    /**
     * Displays a single Bases model.
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
     * Creates a new Bases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Bases();
        $model->user_id = Yii::$app->user->id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionIncome()
    {
        $this->layout = 'blank';
        $model = new BaseIncome();
        $products = ArrayHelper::map(Products::find()->all(), 'id', 'name_uz');
        $contractors = ArrayHelper::map(Contractors::find()->all(), 'id', 'name');
        $bases = ArrayHelper::map(Bases::find()->all(), 'id', 'name_uz');
        $rate = ExchangeRates::getRateByDate(date('Y-m-d'));
        $model->date = date("d-m-Y");

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                //sanani togirlab olamiz
                if ($model->date == "") {
                    $model->date = date("Y-m-d");
                } else {
                    $model->date = date("Y-m-d", strtotime($model->date));
                }
                $model->amount = (float) (str_replace(',', '', str_replace(' ', '', $model->amount))); //floatval(), 2, '.', '' );
                $myspecial = $model->special;
                unset($model->special);
                // echo "<pre>";
                // print_r($_POST);
                // // print_r($myspecial);
                // echo "</pre>";
                // exit();
                $model->save();
                foreach ($myspecial as $p) :
                    $item = new PiItems();
                    $item->pi_id = $model->id;
                    $item->product_id = $p['product_id'];
                    $item->qty = $this->removeSpaces($p['qty']);
                    $item->volume = $this->removeSpaces($p['volume']);
                    $item->price = $this->removeSpaces($p['price']);
                    $item->amount = $this->removeSpaces($p['amount']);
                    $item->save();
                    // echo "<pre>";
                    // print_r($model->getErrors());
                    // print_r($item->getErrors());
                    // echo "</pre>";
                    // exit();
                    BaseRemains::addQty($model->base_id, $p['product_id'], $p['qty']);
                    BaseIncome::addIncome($item->id, $model->base_id, $p['product_id'], $p['qty'], $p['price'], $p['amount'], $model->current_rate, $model->date, $model->contractor_id);
                endforeach;
                if ($model->contractor_id != "") {
                    $w = [
                        'contractor_id' => $model->contractor_id,
                        'cost_sum' => $model->amount,
                        'cost_usd' => 0,
                    ];
                    Contractors::removeRemains($w);
                }
                Yii::$app->session->setFlash("success", Yii::t('app', "Ma'lumotlar muvaffaqiyatli saqlandi!"));
                return $this->redirect('incomes');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('income', [
            'model' => $model,
            'products' => $products,
            'bases' => $bases,
            'rate' => $rate,
            'contractors' => $contractors,
        ]);
    }
    public function actionIncomes()
    {
        $model = BaseIncome::find()
            ->all();
        $products = Products::find()->all();
        $bases = Bases::find()->all();
        $contractors = Contractors::find()->all();
        return $this->render(
            'incomes',
            [
                'model' => $model,
                'products' => $products,
                'bases' => $bases,
                'contractors' => $contractors,
            ]
        );
    }
    /**
     * Updates an existing Bases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Bases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bases::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    private function removeSpaces($number)
    {
        $newNumber = '';
        for ($i = 0; $i < strlen($number); $i++) {
            if ($number[$i] != ' ') {
                $newNumber .= $number[$i];
                $newNumber[$i];
            }
        }
        return $newNumber;
    }
}
