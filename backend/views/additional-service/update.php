<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdditionalService */

$this->title = 'Редактировать: ' . $model->title;
?>
<div class="additional-service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
