<?php

namespace backend\modules\production\controllers;

use backend\models\Stages;
use backend\models\StagesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * StagesController implements the CRUD actions for Stages model.
 */
class StagesController extends Controller
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
     * Lists all Stages models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Stages::find()
            ->orderBy('place asc')
            ->all();
        $items = [];
        foreach ($model  as $m) :
            array_push($items, ['content' => "<div class='myItem text-center'><span class='d-none myNumber'>{$m->id}</span>{$m->name_uz}</div>"]);
        endforeach;
        // echo "<pre>";
        // print_r($items);
        // echo "</pre>";
        // exit();
        return $this->render('index', [
            'items' => $items,
            'model' => $model,
        ]);
    }
    public function actionUpdatePlace()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sql = "";
        foreach ($_POST['data'] as $k => $v) :
            $id = $v;
            $i = $k + 1;
            $sql .= "UPDATE `stages` SET `place` = '{$i}' WHERE `stages`.`id` = {$id}; ";
        endforeach;
        Yii::$app->db->createCommand($sql)->execute();
        return json_encode($sql);
    }
    public function actionList()
    {
        $searchModel = new StagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Stages model.
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
     * Creates a new Stages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Stages();
        $sql = "SELECT *FROM auth_item where `type` = 1";
        $positions = Yii::$app->db->createCommand($sql)->queryAll();
        $positions = ArrayHelper::map($positions, 'name', 'name');
        // echo "<pre>";
        // print_r($positions);
        // echo "</pre>";
        // exit();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->position = json_encode($model->position);
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'positions' => $positions
        ]);
    }

    /**
     * Updates an existing Stages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->position = json_decode($model->position);
        $sql = "SELECT *FROM auth_item where `type` = 1";
        $positions = Yii::$app->db->createCommand($sql)->queryAll();
        $positions = ArrayHelper::map($positions, 'name', 'name');

        if ($this->request->isPost && $model->load($this->request->post()) ) {
            $model->position = json_encode($model->position);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'positions' => $positions,
        ]);
    }

    /**
     * Deletes an existing Stages model.
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
     * Finds the Stages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Stages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
