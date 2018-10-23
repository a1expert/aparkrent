<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AutoMark */

$this->title = 'Редактировать марку: ' . $model->title;
?>
<div class="auto-mark-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
