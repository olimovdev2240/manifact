<?php

namespace backend\modules\base\controllers;

use backend\models\Bases;
use backend\models\User;
use yii\web\Controller;

/**
 * Default controller for the `base` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $bases = Bases::find()->all();
        $users = User::find()->all();
        return $this->render('index', [
            'bases' => $bases,
            'users' => $users,
        ]);
    }
}
