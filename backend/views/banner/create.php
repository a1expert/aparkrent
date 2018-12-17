<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Banner */

$this->title = 'Создать баннер';
?>
<div class="auto-mark-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
