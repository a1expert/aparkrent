<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Tariff */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тарифы';
?>
<div class="tariff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создание тарифа', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'time',
            'price_for_day',
            'model.title',
            'minimal_days',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
