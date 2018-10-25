<?php
/**
 * Created at 17.11.2017 18:56
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var Reserve $model
 */
use backend\models\Reserve;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$attributes = [
    [
        'attribute' => 'client_id',
        'label' => 'Клиент',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->client != null) {
                return Html::a($model->client->fullName, Url::to(['/client/view', 'id' => $model->client->id]), ['target' => '_blank']);
            } else {
                return 'Не указан';
            }
        }
    ],
    'model.title',
    [
        'attribute' => 'price',
        'format' => 'raw',
        'value' => function ($model) {
            return '<div class="js-price-target">' . $model->price . '</div> ' . Html::a('Просчитать по параметрам', Url::to(['/reserve/count-price', 'id' => $model->id]), ['class' => 'js-count-price']);
        }
    ],
    [
        'attribute' => 'delivery_date',
        'value' => function ($model) {
            return Yii::$app->formatter->asDatetime($model->delivery_date, 'd-M-Y');
        }
    ],
    [
        'attribute' => 'return_date',
        'value' => function ($model) {
            return Yii::$app->formatter->asDatetime($model->return_date, 'd-M-Y');
        }
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return $model->statusArray[$model->status];
        }
    ],
    [
        'attribute' => 'source',
        'value' => function ($model) {
            return $model->sourceArray[$model->source];
        }
    ],
    'comment',
];

if ($model->status == Reserve::STATUS_ACCEPTED) {
    $attributes[] = [
        'attribute' => 'paidAt',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->paidAt == null) {
                if ($model->invoice && $model->invoice->price != null) {
                    return 'Не оплачено' . '<div class="green table-button js-set-pay" data-url="'.Url::to(['/invoice/set-pay', 'id' => $model->invoice->id]).'">Оплатить</div>';
                } else {
                    return 'Не оплачено';
                }
            } else {
                return Yii::$app->formatter->asDatetime($model->paidAt, 'd-M-Y HH:mm:ss') . '<div class="red table-button js-return-pay" data-url="'.Url::to(['/invoice/return-pay', 'id' => $model->invoice->id]).'">Отменить</div>';
            }
        }
    ];
}

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
]) ?>
<?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
<?php if ($model->paidAt == null): ?>
    <div class="btn btn-success js-update-and-new-to-reserve" data-id="<?= $model->id ?>" data-url="<?= Url::to(['/reserve/add-service']) ?>">Добавить услугу</div>
<?php endif; ?>
<div id="services">
    <div class="js-content">
        <?= $this->render('services/list', [
            'model' => $model,
        ]); ?>
    </div>
</div>
