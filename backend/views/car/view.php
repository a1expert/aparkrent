<?php

use backend\assets\CarAsset;
use yii\helpers\Html;
use yii\widgets\ActiveFormAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Car */

CarAsset::register($this);
$this->title = $model->number;
?>
<div class="car-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'model_id',
            'number',
            'vin',
            'year_of_issue',
            'registration_certificate',
        ],
    ]) ?>

    <?= $this->render('defects/list', ['model' => $model]) ?>

</div>
