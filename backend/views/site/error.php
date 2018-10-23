<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use backend\assets\NavAsset;
use yii\helpers\Html;

$this->title = $name;

NavAsset::register($this);
?>

<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Произошла ошибка во время выполнения вашего запроса.
    </p>
    <p>
        Пожалуйста, обратитесь к нам, если вы считаете что это ошибка сервера. Спасибо.
    </p>

</div>
