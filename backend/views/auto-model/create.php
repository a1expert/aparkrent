<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AutoModel */

$this->title = 'Создать модель';
?>
<div class="auto-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
