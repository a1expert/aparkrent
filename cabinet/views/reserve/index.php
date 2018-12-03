<?php

/** @var Reserve $reserve
 *  @var \cabinet\models\Client $client
 *  @var integer $status
 */

use cabinet\models\Reserve;

$this->title = 'Мои заказы - Личный кабинет';


$client = Yii::$app->user->identity->client;

$reserves = $client->getReservesByStatus($status);
?>
<div class="block_body">
    <div class="button-block-table">
        <a href="<?= \yii\helpers\Url::to(['', 'status' => Reserve::LEAD_STATUS_OPEN]) ?>" class="button <?= $status == Reserve::LEAD_STATUS_OPEN ? 'active' : '' ?>"> Активные</a>
        <a href="<?= \yii\helpers\Url::to(['', 'status' => Reserve::LEAD_STATUS_CLOSE]) ?>" class="button <?= $status == Reserve::LEAD_STATUS_CLOSE ? 'active' : '' ?>">Закрытые</a>
    </div>
    <div class="block_info">
        <table class="history_table" data-id=0>
            <tr class="title">
                <td class="">Номер заказа</td>
                <td class="">Дата аренды</td>
                <td class="">Автомобиль</td>
                <td class="">Номер</td>
                <td class="">Стоимость</td>
            </tr>
            <?php foreach ($reserves as $reserve) : ?>
                <tr class="">
                    <td class="">№<?= $reserve->id ?><br>
                        <?php if (!empty($reserve->files)) :?>
                            <a href="<?= \yii\helpers\Url::to(['/reserve/documents', 'id' => $reserve->id]) ?>">Документы</a>
                        <?php endif; ?>
                    </td>
                    <td class="">
                        <?= $reserve->getRentDate() ?>
                    </td>
                    <td class=""><?= $reserve->model->mark->title . ' ' . $reserve->model->title ?></td>
                    <td class=""><?= $reserve->car == null ? '---' : $reserve->car->number ?></td>
                    <td class="">
                        <?php if ($reserve->invoice && $reserve->invoice->price) :?>
                            <?= number_format($reserve->invoice->price, 0, '.', ' ') ?> <br>
                            <a href="<?= \yii\helpers\Url::to(['/site/payment', 'id' => $reserve->invoice->id]) ?>">Подробнее</a>
                        <?php else:?>
                            Не установлено
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>