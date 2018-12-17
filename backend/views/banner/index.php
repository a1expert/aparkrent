<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Баннеры';
?>
<div class="auto-mark-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать баннер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title_1',
            'title_2',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
            ],
        ],
    ]); ?>
</div>
