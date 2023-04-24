<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\ErrorAsset;
use yii\bootstrap5\Html;

ErrorAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="authentication">
    <?php $this->beginBody() ?>

    <!-- Loading starts -->
    <div id="loading-wrapper">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Loading ends -->


        <?= $content ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
