<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Banner */

$this->title = $model->title_1;
?>
<div class="auto-mark-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'image',
                'format' => 'image',
                'value' => function ($model) {
                    return Yii::$app->params['frontend'] . $model->image;
                }
            ],
            'title_1',
            'title_2',
        ],
    ]) ?>

</div>
