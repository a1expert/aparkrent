<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AutoClass */

$this->title = 'Создать класс';
?>
<div class="auto-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
