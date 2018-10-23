<?php

use backend\assets\ClientAsset;
use backend\models\Client;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->controller->action->id == 'potential' ? 'Новые клиенты' : 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
ClientAsset::register($this);

if ($searchModel->type == Client::TYPE_LEGAL) {
    $columns = [
        'company_name',
        'inn',
        'kpp',
        'phone',
    ];
} else {
    $columns = [
        'fullName',
        'birthday:date',
        'phone',
    ];
}
$columns[] = [
    'attribute' => 'bonus_balance',
    'value' => function ($model) {
        return (float)$model->bonus_balance;
    }
];
$columns[] = [
    'attribute' => 'status',
    'format' => 'raw',
    'filter' => Client::getStatusArray(),
    'value' => function ($model) {
        $text = '<select class="js-client-change-status" data-id="' . $model->id . '">';
        foreach (Client::getStatusArray() as $key => $status) {
            $text .= '<option value="' . $key . '" ' . ($key == $model->status ? 'selected' : '') . '>' . $status . '</option>';
        }
        $text .= '</select>';
        return $text;
    }
];
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}{update}{delete}',
];
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать клиента', ['create', 'type' => $searchModel->type], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="client-selectors">
        <a href="<?= \yii\helpers\Url::to(['/client/index', 'ClientSearch[type]' => Client::TYPE_INDIVIDUAL]) ?>"  class="client-selector <?= $searchModel->type == Client::TYPE_INDIVIDUAL ? 'active' : '' ?>">Физ. лица</a>
        <a href="<?= \yii\helpers\Url::to(['/client/index', 'ClientSearch[type]' => Client::TYPE_LEGAL]) ?>" class="client-selector <?= $searchModel->type == Client::TYPE_LEGAL ? 'active' : '' ?>">Юр. лица</a>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $class = '';
            if ($model->status == Client::STATUS_NOT_VERIFIED) {
                $class = 'red client';
            }
            if ($model->status == Client::STATUS_VERIFIED) {
                $class = 'green client';
            }
            if ($model->status == Client::STATUS_DENIED) {
                $class = 'gray client';
            }
            return [
                'class' => $class,
            ];
        },
        'columns' => $columns,
    ]); ?>
</div>
