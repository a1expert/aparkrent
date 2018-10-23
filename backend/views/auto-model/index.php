<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AutoModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модели';
?>
<div class="auto-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать модели', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mark.title',
            'title',
//            'description:ntext',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(Yii::$app->params['frontend'] . $model->image, [
                        'style' => [
                            'max-width' => '400px',
                            'max-height' => '400px',
                        ],
                    ]);
                }
            ],
            [
                'attribute' => 'visibility',
                'value' => function ($model) {
                    return $model->visibility == 1?'да':'нет';
                }
            ],
            // 'equipment',
            // 'engine',
            // 'disk',
            // 'audio',
            // 'class_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
            ],
        ],
    ]); ?>
</div>
