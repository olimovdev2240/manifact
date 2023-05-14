<?php

namespace backend\modules\production\controllers;

use backend\models\ProductionProccess;
use backend\models\Products;
use backend\models\Stages;
use backend\models\Workers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Default controller for the `production` module
 */
class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'index') {
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
        $stages = Stages::find()
            ->orderBy('place')
            ->all();
        $model = new ProductionProccess();
        $stages = ArrayHelper::map($stages, 'id', 'name_uz');
        // echo "<pre>";
        // print_r($stages);
        // echo "</pre>";
        // exit();
        return $this->render('index', [
            'stages' => $stages,
            'model' => $model,
        ]);
    }
    public function actionGetNewProduction()
    {
        $stages = Stages::find()
            ->orderBy('place asc')
            ->all();
        $model = new ProductionProccess();
        $stages = ArrayHelper::map($stages, 'id', 'name_uz');
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->qty = $_POST['qty'];
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->saveProccess()) {
                if ($model->photo != "") {
                    $model->upload();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Amal muvaffaqiyatli bajarildi!'));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Qiymatlar kiritilishida xatolik bor!'));
                return $this->redirect('index');
            }
            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // exit();
        }
        return $this->renderAjax('new-production', [
            'stages' => $stages,
            'model' => $model,
        ]);
    }
    public function actionProductionManager()
    {
        $products = Products::find()
            ->orderBy('id asc')
            // ->where(['type_id' => 1])
            ->where(['type_id' => 1])
            ->orWhere(['type_id' => 2])
            ->all();
        $stages = Stages::find()
            ->orderBy('place')
            ->all();
        $stages = ArrayHelper::map($stages, 'id', 'name_uz');
        $workers = ArrayHelper::map(Workers::find()->asArray()->all(), 'id', 'full_name');
        $model = new ProductionProccess();
        $products = ArrayHelper::map($products, 'id', 'name_uz');
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->qty = $_POST['qty'];
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->saveProccessByManager()) {
                if ($model->photo != "") {
                    $model->upload();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Amal muvaffaqiyatli bajarildi!'));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                // echo "<pre>";
                // print_r($model);
                // echo "</pre>";
                // exit();
                Yii::$app->session->setFlash('error', Yii::t('app', 'Qiymatlar kiritilishida xatolik bor!'));
                return $this->redirect(Yii::$app->request->referrer);
            }
            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // exit();
        }
        return $this->render('manager', [
            'products' => $products,
            'model' => $model,
            'workers' => $workers,
            'stages' => $stages,
        ]);
    }
    public function actionProductionHalf()
    {
        $products = Products::find()
            ->orderBy('id asc')
            ->where(['type_id' => 1])
            ->all();
        $model = new ProductionProccess();
        $products = ArrayHelper::map($products, 'id', 'name_uz');
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->qty = $_POST['qty'];
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->saveProccess()) {
                if ($model->photo != "") {
                    $model->upload();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Amal muvaffaqiyatli bajarildi!'));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                // echo "<pre>";
                // print_r($model);
                // echo "</pre>";
                // exit();
                Yii::$app->session->setFlash('error', Yii::t('app', 'Qiymatlar kiritilishida xatolik bor!'));
                return $this->redirect(Yii::$app->request->referrer);
            }
            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // exit();
        }
        return $this->render('new-production-half', [
            'products' => $products,
            'model' => $model,
        ]);
    }
    public function actionPackaging()
    {
        $products = Products::find()
            ->orderBy('id asc')
            ->where(['type_id' => 2])
            ->all();
        $model = new ProductionProccess();
        $products = ArrayHelper::map($products, 'id', 'name_uz');
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->qty = $_POST['qty'];
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->savePackage()) {
                if ($model->photo != "") {
                    $model->upload();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Amal muvaffaqiyatli bajarildi!'));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Qiymatlar kiritilishida xatolik bor!'));
                return $this->redirect(Yii::$app->request->referrer);
            }
            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // exit();

        }
        return $this->render('packaging', [
            'products' => $products,
            'model' => $model,
        ]);
    }
}
