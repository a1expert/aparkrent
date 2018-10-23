<?php
/**
 * Created at 12.10.2017 14:28
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
use backend\assets\ReserveAsset;
use backend\models\Reserve;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Сделки';

ReserveAsset::register($this);
?>
<div class="reserve-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать сделку', ['lead-create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'client.fullNameAndPhone',
            'model.title',
            'car.number',
            'rentDate',
            'price',
            [
                'attribute' => 'lead_status',
                'format' => 'raw',
                'filter' => Reserve::getLeadStatusArray(),
                'value' => function ($model) {
                    $text = '<select class="js-reserve-change-lead-status" data-id="' . $model->id . '">';
                    foreach (Reserve::getLeadStatusArray() as $key => $status) {
                        $text .= '<option value="' . $key . '" ' . ($key == $model->lead_status ? 'selected' : '') . '>' . $status . '</option>';
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
