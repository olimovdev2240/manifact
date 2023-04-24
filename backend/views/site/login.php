<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<!-- <form action="index.html"> -->
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
<div class="row justify-content-md-center">
    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
        <div class="login-screen">
            <div class="login-box">
                <a href="#" class="login-logo">
                    <img src="/img/logo-dark.png" alt="Wafi Admin Dashboard" />
                </a>
                <h5><?=Yii::t('app', 'Akkountga kirish oynasi')?></h5>
                <div class="form-group">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                    <!-- <input type="text" class="form-control" placeholder="Email Address" /> -->
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <!-- <input type="password" class="form-control" placeholder="Password" /> -->
                </div>
                <div class="actions mb-4">
                    <div class="custom-control custom-checkbox">
                        <!-- <input type="checkbox" class="custom-control-input" id="remember_pwd"> -->
                        <!-- <label class="custom-control-label" for="remember_pwd">Remember me</label> -->
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Login</button> -->
                    <?= Html::submitButton(Yii::t('app', 'Kirish'), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!-- </form> -->