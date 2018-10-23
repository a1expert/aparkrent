<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\forms\ReserveForm */

$this->title = 'Редактирование ' . ($model->reserve->status == \backend\models\Reserve::STATUS_ACCEPTED ? 'сделки' : 'заявки') . ' номер ' . $model->reserve->id;
\backend\assets\ClientAsset::register($this);
?>
<div class="reserve-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
