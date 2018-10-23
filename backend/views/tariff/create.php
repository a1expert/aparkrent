<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */

$this->title = 'Создание тарифа';
?>
<div class="tariff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
