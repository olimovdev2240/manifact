<?php

namespace backend\modules\sale\controllers;

use backend\models\BaseIncome;
use backend\models\BaseRemains;
use backend\models\Bases;
use backend\models\Contractors;
use backend\models\ExchangeRates;
use backend\models\Products;
use backend\models\ReturnCustomer;
use backend\models\ReturnCustomerSearch;
use backend\models\RcItems;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ReturnCustomerController implements the CRUD actions for ReturnCustomer model.
 */
class ReturnCustomerController extends Controller
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
     * Lists all ReturnCustomer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReturnCustomerSearch();
        $bases = ArrayHelper::map(Bases::find()->all(), 'id', 'name');
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bases' => $bases,
        ]);
    }

    /**
     * Displays a single ReturnCustomer model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //kiritilgan qoldiqlar
        $special = RcItems::getAdditionalAttributes($id);
        return $this->render('view', [
            'model' => $model,
            'myspecial' => $special,
        ]);
    }

    public function actionCreate()
    {
        $model = new ReturnCustomer();
        $products = ArrayHelper::map(Products::find()->all(), 'id', 'name');
        $contractors = ArrayHelper::map(Contractors::find()->all(), 'id', 'name');
        $bases = ArrayHelper::map(Bases::find()->all(), 'id', 'name');
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
                $model->user_id = Yii::$app->user->id;
                $model->amount_sum = (float) (str_replace(',', '', str_replace(' ', '', $model->amount_sum))); //floatval(), 2, '.', '' );
                $model->vat_sum = (float) (str_replace(',', '', str_replace(' ', '', $model->vat_sum))); //floatval(), 2, '.', '' );
                $model->cost_sum = (float) (str_replace(',', '', str_replace(' ', '', $model->cost_sum))); //floatval(), 2, '.', '' );
                $model->amount_usd = (float) (str_replace(',', '', str_replace(' ', '', $model->amount_usd))); //floatval(), 2, '.', '' );
                $model->vat_usd = (float) (str_replace(',', '', str_replace(' ', '', $model->vat_usd))); //floatval(), 2, '.', '' );
                $model->cost_usd = (float) (str_replace(',', '', str_replace(' ', '', $model->cost_usd))); //floatval(), 2, '.', '' );
                $myspecial = $model->special;
                unset($model->special);
                $model->save();
                // echo "<pre>";
                // print_r($model);
                // print_r($myspecial);
                // echo "</pre>";
                // exit();
                foreach ($myspecial as $p) :
                    $item = new RcItems();
                    $item->rc_id = $model->id;
                    $item->product_id = $p['product_id'];
                    $item->qty = $this->removeSpaces($p['qty']);
                    $item->value = $this->removeSpaces($p['value']);
                    $item->price = $this->removeSpaces($p['price']);
                    $item->exchange = $p['exchange'];
                    $item->fee = $p['fee'];
                    $item->remains = $p['remains'];
                    $item->vat_bet = $this->removeSpaces($p['vat_bet']);
                    $item->amount = $this->removeSpaces($p['amount']);
                    $item->amount_with_vat = $this->removeSpaces($p['amount_with_vat']);
                    $item->save();
                    // echo "<pre>";
                    // print_r($item);
                    // echo "</pre>";
                    // exit();
                    BaseRemains::addQty($model->base_id, $p['product_id'], $p['qty']);
                    BaseIncome::addQtyByFIFO($model->base_id, $p['product_id'], $p['qty']);
                endforeach;
                $w = [
                    'contractor_id' => $model->contractor_id,
                    'cost_sum' => $model->amount_sum,
                    'cost_usd' => $model->amount_usd,
                ];
                Contractors::removeRemains($w);
                return $this->redirect('index');
                // echo "<pre>";
                // print_r($model);
                // echo "</pre>";
                // exit();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
            'bases' => $bases,
            'rate' => $rate,
            'contractors' => $contractors,
        ]);
    }
    private function removeSpaces($number)
    {
        $newNumber = '';
        for ($i = 0; $i < strlen($number); $i++) {
            if ($number[$i] != ' ') {
                $newNumber .= $number[$i];
                // echo $newNumber[$i];
            }
        }
        return $newNumber;
    }

    public function actionUpdateItem($id)
    {
        $m = RcItems::findOne($id);
        $model = ReturnCustomer::findOne($m->rc_id);
        $products = ArrayHelper::map(Products::find()->all(), 'id', 'name');
        if ($this->request->isPost) {
            //eski vozvratni togirlash
            BaseRemains::removeQty($model->base_id, $m['product_id'], $m['qty']); // bazadan maxsulot ayirib qoyildi
            BaseIncome::removeQtyByFIFO($model->base_id, $m['product_id'], $m['qty']);
            $aSum = 0;
            $aUsd = 0;
            if ($m->exchange) {
                $aUsd = $m->amount_with_vat;
            } else {
                $aSum = $m->amount_with_vat;
            }
            $w = [
                'contractor_id' => $model->contractor_id,
                'cost_sum' => $aSum,
                'cost_usd' => $aUsd,
            ];
            Contractors::addRemains($w); // ozgargan summa contractorda togirlandi
            //eski summa vozvrat umumiydan ayirib qoyildi
            $model->amount_sum -= $aSum;
            $model->amount_usd -= $aUsd;
            //yangilarni saqlab ketamiz
            $m->product_id = $_POST['RcItems']['product_id'];
            $m->value = $_POST['RcItems']['value'];
            $m->qty = $_POST['RcItems']['qty'];
            $m->price = $_POST['RcItems']['price'];
            $m->amount = $_POST['RcItems']['amount'];
            $m->fee = $_POST['RcItems']['fee'];
            $m->remains = $_POST['RcItems']['remains'];
            $m->exchange = $_POST['RcItems']['exchange'];
            $m->vat_bet = $_POST['RcItems']['vat_bet'];
            $m->amount_with_vat = $_POST['RcItems']['amount_with_vat'];
            $m->save();
            BaseRemains::addQty($model->base_id, $m['product_id'], $m['qty']); // bazaga maxsulot qoshib qoyildi
            BaseIncome::addQtyByFIFO($model->base_id, $m['product_id'], $m['qty']);
            $aSum = 0;
            $aUsd = 0;
            if ($m->exchange) {
                $aUsd = $m->amount_with_vat;
            } else {
                $aSum = $m->amount_with_vat;
            }
            $w = [
                'contractor_id' => $model->contractor_id,
                'cost_sum' => $aSum,
                'cost_usd' => $aUsd,
            ];
            Contractors::removeRemains($w); // ozgargan summa contractorda yangilandi
            //ozgargan summa vozvrat umumiydan ayirib qoyildi
            $model->amount_sum += $aSum;
            $model->amount_usd += $aUsd;
            $model->save();

            Yii::$app->session->setFlash('success', Yii::t('app', 'Muvaffaqiyatli o`zgartirildi!'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update-item', [
            'm' => $m,
            'products' => $products,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contractors = ArrayHelper::map(Contractors::find()->all(), 'id', 'name');
        $bases = ArrayHelper::map(Bases::find()->all(), 'id', 'name');
        $special = RcItems::getAdditionalAttributes($id);
        $oldBase = $model->base_id;
        $oldContr = $model->contractor_id;
        $oldAmountSum = $model->amount_sum;
        $oldAmountUsd = $model->amount_usd;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            //eski vozvratni togirlash
            if ($oldBase != $model->base_id) :
                foreach ($special as $p) :
                    BaseRemains::removeQty($oldBase, $p['product_id'], $p['qty']);
                    BaseIncome::removeQtyByFIFO($oldBase, $p['product_id'], $p['qty']);
                endforeach;
            endif;
            $w = [
                'contractor_id' => $oldContr,
                'cost_sum' => $oldAmountSum,
                'cost_usd' => $oldAmountUsd,
            ];
            Contractors::addRemains($w);
            // yangilarni kiritish
            if ($oldBase != $model->base_id) :
                foreach ($special as $p) :
                    BaseRemains::addQty($model->base_id, $p['product_id'], $p['qty']);
                    BaseIncome::addQtyByFIFO($model->base_id, $p['product_id'], $p['qty']);
                endforeach;
            endif;
            $w = [
                'contractor_id' => $model->contractor_id,
                'cost_sum' => $model->amount_sum,
                'cost_usd' => $model->amount_usd,
            ];
            Contractors::removeRemains($w);
            Yii::$app->session->setFlash('success', 'Muvaffaqiyatli o`zgartirildi!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'contractors' => $contractors,
            'bases' => $bases,
        ]);
    }

    public function actionDeleteItem($id)
    {
        $m = RcItems::findone($id);
        $model = ReturnCustomer::findOne($m->rc_id);
        //eski vozvratni togirlash
        BaseRemains::removeQty($model->base_id, $m['product_id'], $m['qty']); // bazadan maxsulot ayirib qoyildi
        BaseIncome::removeQtyByFIFO($model->base_id, $m['product_id'], $m['qty']);
        $aSum = 0;
        $aUsd = 0;
        if ($m->exchange) {
            $aUsd = $m->amount_with_vat;
        } else {
            $aSum = $m->amount_with_vat;
        }
        $w = [
            'contractor_id' => $model->contractor_id,
            'cost_sum' => $aSum,
            'cost_usd' => $aUsd,
        ];
        Contractors::addRemains($w); // ozgargan summa contractorda togirlandi
        //eski summa vozvrat umumiydan ayirib qoyildi
        $model->amount_sum -= $aSum;
        $model->amount_usd -= $aUsd;
        $m->delete();
        Yii::$app->session->setFlash('warning', Yii::t('app', 'Element o`chirildi!'));
        if (ReturnCustomer::isNull($m->rc_id)) {
            $model->delete();
            return $this->redirect(['index']);
        }
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $special = RcItems::getAdditionalAttributes($id);
        foreach ($special as $p) :
            BaseRemains::removeQty($model->base_id, $p['product_id'], $p['qty']);
            BaseIncome::removeQtyByFIFO($model->base_id, $p['product_id'], $p['qty']);
        endforeach;
        $w = [
            'contractor_id' => $model->contractor_id,
            'cost_sum' => $model->amount_sum,
            'cost_usd' => $model->amount_usd,
        ];
        Contractors::addRemains($w);
        $model->delete();
        Yii::$app->session->setFlash('warning', 'Muvaffaqiyatli o`chirildi!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the ReturnCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReturnCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReturnCustomer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
