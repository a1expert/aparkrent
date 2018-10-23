<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AutoModel */

$this->title = 'Редактировать модель: ' . $model->title;
?>
<div class="auto-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
