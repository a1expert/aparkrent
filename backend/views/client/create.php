<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Client */

$this->title = 'Создание клиента';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
