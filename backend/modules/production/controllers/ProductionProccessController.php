<?php

namespace backend\modules\production\controllers;

use backend\models\BaseRemains;
use backend\models\Bases;
use backend\models\ProductionProccess;
use backend\models\ProductionProccessFullSearch;
use backend\models\ProductionProccessHalfSearch;
use backend\models\ProductionProccessSearch;
use backend\models\Workers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionProccessController implements the CRUD actions for ProductionProccess model.
 */
class ProductionProccessController extends Controller
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
    public function beforeAction($action)
    {
        if ($action->id == 'half' || $action->id == 'full' ) {
            $this->enableCsrfValidation = false;
        }
        //return true;
        return parent::beforeAction($action);
    }

    /**
     * Lists all ProductionProccess models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductionProccessSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionHalf()
    {
        $query = ProductionProccess::find()
            ->leftJoin('products', 'products.id=production_proccess.product_id')
            ->leftJoin('workers', 'workers.id=production_proccess.worker_id')
            ->where(['products.type_id' => 1, 'is_counted' => 0]);
        if (!empty($_POST['search'])) {
            // echo $_POST['search'];
            // exit;
            $query->andWhere([
                'or',
                ['like', 'products.name_uz',  '%' . $_POST['search'] . '%', false],
                ['like', 'workers.full_name',  '%' . $_POST['search'] . '%', false],
            ]);
        }
        $count = $query->count();
        $pagination = new \yii\data\Pagination(['totalCount' => $count, 'pageSize' => 18]);
        $model = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('half', [
            'model' => $model,
            'pagination' => $pagination
        ]);
    }
    public function actionFull()
    {
        $query = ProductionProccess::find()
            ->leftJoin('products', 'products.id=production_proccess.product_id')
            ->leftJoin('workers', 'workers.id=production_proccess.worker_id')
            ->where(['products.type_id' => 2, 'is_counted' => 0]);
        if (!empty($_POST['search'])) {
            // echo $_POST['search'];
            // exit;
            $query->andWhere([
                'or',
                ['like', 'products.name_uz',  '%' . $_POST['search'] . '%', false],
                ['like', 'workers.full_name',  '%' . $_POST['search'] . '%', false],
            ]);
        }
        $count = $query->count();
        $pagination = new \yii\data\Pagination(['totalCount' => $count, 'pageSize' => 18]);
        $model = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('full', [
            'model' => $model,
            'pagination' => $pagination
        ]);
    }
    public function actionCount()
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'id mavjud emas'));
            $this->goBack();
        }
        $model = $this->findModel($id);
        if ($model->is_counted) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'status allaqachon o`zgartirilgan'));
            $this->goBack();
        }
        $model->is_counted = 1;
        $model->qty -= $model->invalid;
        $model->counted_at = date("Y-m-d H:i");
        if ($model->save()) {
            Workers::addSalary($model->qty * $model->salary, $model->worker_id);
            Yii::$app->session->setFlash('info', Yii::t('app', 'Status o`zgartirildi'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->setFlash('danger', Yii::t('app', 'Status o`zgartirishda xatolik bor'));
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    public function actionAbort()
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'id mavjud emas'));
            $this->goBack();
        }
        $model = $this->findModel($id);
        $model->invalid = $_GET['val'];
        if ($model->save()) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'Status o`zgartirildi'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->setFlash('danger', Yii::t('app', 'Status o`zgartirishda xatolik bor'));
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Displays a single ProductionProccess model.
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
     * Creates a new ProductionProccess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductionProccess();

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

    /**
     * Updates an existing ProductionProccess model.
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
     * Deletes an existing ProductionProccess model.
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
     * Finds the ProductionProccess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductionProccess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductionProccess::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
