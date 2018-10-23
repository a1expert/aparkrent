<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AutoModel */

$this->title = $model->title;
?>
<div class="auto-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:ntext',
            'mark.title',
            [
                'attribute' => 'image',
                'format' => 'image',
                'value' => function ($model) {
                    return Yii::$app->params['frontend'] . $model->image;
                }
            ],
            'equipment',
            'engine',
            [
                'attribute' => 'conditioner',
                'value' => function ($model) {
                    return $model->conditioner == 1 ? 'Есть' : 'Нет';
                }
            ],
            'audio',
            'class.title',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == \backend\models\AutoModel::STATUS_ACTIVE ? 'Активен' : 'Не активен';
                }
            ],
            [
                'attribute' => 'visibility',
                'value' => function ($model) {
                    return $model->visibility == 1?'да':'нет';
                }
            ],
        ],
    ]) ?>

</div>
