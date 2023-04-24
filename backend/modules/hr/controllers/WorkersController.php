<?php

namespace backend\modules\hr\controllers;

use backend\models\SignupForm;
use backend\models\Workers;
use backend\models\WorkersSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * WorkersController implements the CRUD actions for Workers model.
 */
class WorkersController extends Controller
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
     * Lists all Workers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAdd()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Ro`yxatdan muvaffaqiyatli o`tkazildi!'));
            Yii::$app->session->setFlash('special', $model->signup());
            return $this->redirect('create');
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }
    /**
     * Displays a single Workers model.
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
     * Creates a new Workers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(!$this->request->isPost){
            if(!Yii::$app->session->hasFlash('special')){
                Yii::$app->session->setFlash("warning", Yii::t('app', "Avval login parolni kiriting!"));
                return $this->redirect('add');
            }
        }
        $model = new Workers();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // echo "<pre>";
                // print_r($model);
                // print_r($_FILES);
                // echo "</pre>";
                // exit();
                $model->photo = UploadedFile::getInstance($model, 'photo');
                if ($model->save()) {
                    if ($model->upload()) {
                        Yii::$app->session->setFlash('success', Yii::t('app', "Ma'lumotlar muvaffaqiyatli saqlandi!"));
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        echo "<pre>";
                        print_r($model->getErrors());
                        echo "</pre>";
                        exit();
                    }
                } else {
                    // echo "<pre>";
                    // print_r($model->getErrors());
                    // echo "</pre>";
                    // exit();
                    Yii::$app->session->setFlash('error', Yii::t('app', "Ma'lumotlar saqlanmadi!"));
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Workers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if ($_FILES['Workers']['name'] != "") {
                $model->photo = UploadedFile::getInstance($model, 'photo');
                $model->save();
                $model->upload();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Workers model.
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
     * Finds the Workers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Workers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
