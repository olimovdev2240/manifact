<?php

namespace backend\modules\hr\controllers;

use backend\models\ComeReport;
use backend\models\ComeReportSearch;
use backend\models\Workers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ComeReportController implements the CRUD actions for ComeReport model.
 */
class ComeReportController extends Controller
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
     * Lists all ComeReport models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComeReportSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComeReport model.
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
     * Creates a new ComeReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ComeReport();
        $workers = ArrayHelper::map(Workers::find()->where(['type_of_work' => Workers::DAYLY])->all(), 'id', 'full_name');
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if ($model->checked) {
                    if (Workers::addSalary($model->salary, $model->worker_id)) {
                        Yii::$app->session->setFlash('success', 'Amallar muvaffaqiyatli bajarildi!');
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->session->setFlash('danger', 'Oylik hisoblashda xatolik bor');
                        return $this->redirect(['index']);
                    }
                }
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'workers' => $workers,
        ]);
    }

    /**
     * Updates an existing ComeReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $workers = ArrayHelper::map(Workers::find()->where(['type_of_work' => Workers::DAYLY])->all(), 'id', 'full_name');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'workers' => $workers
        ]);
    }

    /**
     * Deletes an existing ComeReport model.
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
    public function actionAccept()
    {
        if (empty($_GET['id'])) {
            Yii::$app->session->setFlash('danger', 'id mavjud emas');
            $this->goBack();
        }
        $model = ComeReport::findOne(['id' => $_GET['id']]);
        $model->checked = 1;
        if ($model->save()) {
            if (Workers::addSalary($model->salary, $model->worker_id)) {
                Yii::$app->session->setFlash('success', 'Amallar muvaffaqiyatli bajarildi!');
                return $this->goBack();
            } else {
                Yii::$app->session->setFlash('danger', 'Oylik hisoblashda xatolik bor');
                return $this->goBack();
            }
        }
    }
    public function actionComeMyself()
    {
        $worker = Workers::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->one();
        $date = date("Y-m-d");
        $sql = "SELECT *FROM come_report where date like '{$date}%'";
        $checkCome = Yii::$app->db->createCommand($sql)->queryOne();
        // echo "<pre>";
        // // print_r($worker);
        // print_r($checkCome);
        // echo "</pre>";
        // exit();
        if (empty($checkCome['id'])) {

            $model = new ComeReport();
            $model->date = date("Y-m-d H:i", strtotime(date("YmdHis") . ' +2 hours'));
            $model->worker_id = $worker->id;
            $model->salary = $worker->salary_of_day;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', "Amallar muvaffaqiyatli bajarildi!"));
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Siz bugungi kelish amalini bajargansiz yoki kunbay ishchi emassiz!"));
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Finds the ComeReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ComeReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComeReport::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
