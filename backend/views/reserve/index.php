<?php

use backend\assets\ReserveAsset;
use backend\models\Reserve;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReserveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';

ReserveAsset::register($this);
?>
<div class="reserve-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $class = '';
            if ($model->status == Reserve::STATUS_NEW) {
                $class = 'red reserve';
            }
            if ($model->status == Reserve::STATUS_ACCEPTED) {
                $class = 'green reserve';
            }
            if ($model->status == Reserve::STATUS_REJECTED) {
                $class = 'gray reserve';
            }
            return [
                'class' => $class,
            ];
        },
        'columns' => [
            'id',
            'client.fullNameAndPhone',
            'model.title',
            'car.number',
            'rentDate',
            'price',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Reserve::getStatusArray(),
                'value' => function ($model) {
                    $text = "<select class=\"js-reserve-change-status\" data-id=\"{$model->id}\">";
                    foreach (Reserve::getStatusArray() as $key => $status) {
                        $text .= '<option value="' . $key . '" ' . ($key == $model->status ? 'selected' : '') . '>' . $status . '</option>';
                    }
                    $text .= '</select>';
                    return $text;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
            ],
        ],
    ]); ?>
</div>
