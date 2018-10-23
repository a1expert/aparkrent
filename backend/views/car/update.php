<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Car */

$this->title = 'Редактирование автомобиля: ' . $model->number;
?>
<div class="car-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
