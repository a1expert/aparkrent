<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\search\AdditionalServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дополнительные услуги';
?>
<div class="additional-service-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'price',
            [
                'attribute' => 'type',
                'filter' => \backend\models\AdditionalService::getTypeArray(),
                'value' => function ($model) {
                    return $model->getTypeArray()[$model->type];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
            ],
        ],
    ]); ?>
</div>
