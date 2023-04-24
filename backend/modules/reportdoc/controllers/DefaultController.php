<?php

namespace backend\modules\reportdoc\controllers;

use backend\models\Bases;
use backend\models\Contractors;
use backend\models\PayOffices;
use backend\models\Products;
use backend\models\Workers;
use yii\web\Controller;

/**
 * Default controller for the `reportdoc` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $offices = PayOffices::find()->all();
        $productdoc = Products::getProductsForDoc();
        $bases = Bases::find()->all();
        $contractors = Contractors::find()->all();
        $workers = Workers::find()->all();
        return $this->render('index', [
            'offices'=>$offices,
            'productdoc'=>$productdoc,
            'bases'=>$bases,
            'contractors'=>$contractors,
            'workers'=>$workers,
        ]);
    }
}
