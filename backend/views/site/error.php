<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception*/

use yii\helpers\Html;
use yii\web\View;

$this->title = $name;
?>
<div id="particles-js"></div>
<div class="countdown-bg"></div>

<div class="error-screen">
    <h1>404</h1>
    <h5><?=Yii::t('app', 'Xatolik')?><br /><?=Yii::t('app', 'Sahifa topilmadi!')?></h5>
    <a href="/" class="btn btn-secondary"><?=Yii::t('app', 'Asosiy sahifaga')?></a>
</div>