<?php

namespace backend\modules\reports\controllers;

use backend\models\Costs;
use backend\models\CostsSearch;
use backend\models\CostTypes;
use backend\models\ExchangeRates;
use backend\models\PayOffices;
use backend\models\ReportSalary;
use backend\models\Workers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CostsController implements the CRUD actions for Costs model.
 */
class CostsController extends Controller
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
     * Lists all Costs models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CostsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Costs model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model =  Costs::findOne($id);
        //xarajatlar va ish haqlari yuklab olinadi
        $se = Costs::getAdditionalAttributes($id);
        $model->salary = $se['salary'];
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Costs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'blank';
        $model = new Costs();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                //sanani togirlab olamiz
                if ($model->date == "") {
                    $model->date = date("Y-m-d H:i");
                } else {
                    $model->date = date("Y-m-d H:i", strtotime($model->date));
                }
                //xarajat va ish haqi buferga olinib unset qilinyabdi
                $salary = $model->salary;
                $expense = $model->expense;
                unset($model->salary);
                unset($model->expense);
                $model->user_id = Yii::$app->user->id;
                $model->current_rate = ExchangeRates::getRateByDate($model->date);
                // echo "<pre>";
                // print_r($model);
                // echo "</pre>";
                // exit();
                $model->save();
                for ($i = 0; $i < count($salary); $i++) {
                    $mSalary = new ReportSalary();
                    $mSalary->cost_id = $model->id;
                    $mSalary->worker_id = $salary[$i]['worker_id'];
                    $mSalary->comment = $salary[$i]['comment'];
                    $mSalary->cost_sum = $this->isNumberNull($salary[$i]['cost_sum']);
                    $mSalary->cost_usd = $this->isNumberNull($salary[$i]['cost_usd']);
                    $mSalary->save();
                    Workers::removeSalary($mSalary->cost_sum, $mSalary->worker_id);
                }
                PayOffices::removeRemains($model);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Muvaffaqiyatli saqlandi!'));
                return $this->redirect(Yii::$app->request->referrer);

                // exit();
            }
        } else {
            $model->loadDefaultValues();
            $model->salary = null;
            $model->expense = null;
        }
        $office = ArrayHelper::map(PayOffices::find()->asArray()->all(), 'id', 'name');
        $workers = ArrayHelper::map(Workers::find()->asArray()->all(), 'id', 'full_name');
        return $this->render('create', [
            'model' => $model,
            'office' => $office,
            'workers' => $workers
        ]);
    }

    public function actionUpdateSalary($id)
    {
        $m = ReportSalary::findOne($id);
        $workers = ArrayHelper::map(Workers::find()->all(), 'id', 'full_name');
        if ($this->request->isPost) {
            ReportSalary::saveWithOld($m->id);
            $cost = Costs::findOne($m['cost_id']);
            $cost->remains_sum -= $_POST['ReportSalary']['cost_sum'];
            $cost->remains_usd -= $_POST['ReportSalary']['cost_usd'];
            $cost->cost_sum += $_POST['ReportSalary']['cost_sum'];
            $cost->cost_usd += $_POST['ReportSalary']['cost_usd'];
            $cost->save();
            $office = PayOffices::findOne($cost->office_id);
            $office->remains_sum -= $_POST['ReportSalary']['cost_sum'];
            $office->remains_usd -= $_POST['ReportSalary']['cost_usd'];
            $office->save();
            $m->worker_id = $_POST['ReportSalary']['worker_id'];
            $m->cost_sum = $_POST['ReportSalary']['cost_sum'];
            $m->cost_usd = $_POST['ReportSalary']['cost_usd'];
            $m->comment = $_POST['ReportSalary']['comment'];
            $m->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update-salary', [
            'm' => $m,
            'workers' => $workers,
        ]);
    }
    // public function actionUpdateExpense($id)
    // {
    //     $m = ReportExpence::findOne($id);
    //     $type = ArrayHelper::map(CostTypes::find()->all(), 'id', 'name');
    //     if ($this->request->isPost) {
    //         ReportExpence::saveWithOld($m->id);
    //         $cost = Costs::findOne($m['cost_id']);
    //         $cost->remains_sum -= $_POST['ReportExpence']['cost_sum'];
    //         $cost->remains_usd -= $_POST['ReportExpence']['cost_usd'];
    //         $cost->cost_sum += $_POST['ReportExpence']['cost_sum'];
    //         $cost->cost_usd += $_POST['ReportExpence']['cost_usd'];
    //         $cost->save();
    //         $office = PayOffices::findOne($cost->office_id);
    //         $office->remains_sum -= $_POST['ReportExpence']['cost_sum'];
    //         $office->remains_usd -= $_POST['ReportExpence']['cost_usd'];
    //         $office->save();
    //         $m->cost_type = $_POST['ReportExpence']['cost_type'];
    //         $m->cost_sum = $_POST['ReportExpence']['cost_sum'];
    //         $m->cost_usd = $_POST['ReportExpence']['cost_usd'];
    //         $m->comment = $_POST['ReportExpence']['comment'];
    //         $m->save();
    //         return $this->redirect(Yii::$app->request->referrer);
    //     }
    //     return $this->renderAjax('update-expense', [
    //         'm' => $m,
    //         'type' => $type
    //     ]);
    // }

    /**
     * Deletes an existing Costs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteSalary($id)
    {
        ReportSalary::saveWithOld($id);
        ReportSalary::findOne($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }
    // public function actionDeleteExpense($id)
    // {
    //     ReportExpence::saveWithOld($id);
    //     ReportExpence::findOne($id)->delete();

    //     return $this->redirect(Yii::$app->request->referrer);
    // }

    /**
     * Finds the Costs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Costs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Costs::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    private function isNumberNull($number)
    {
        if ($number == null) return 0;
        return $number;
    }
}
