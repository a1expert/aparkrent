<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\forms\ReserveForm */

$this->title = $model->reserve->status == null ? 'Создание заявки' : 'Создание сделки';
\backend\assets\ClientAsset::register($this);
?>
<div class="reserve-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
