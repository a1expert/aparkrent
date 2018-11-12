<?php
/** @var \cabinet\models\Client $client
 *  @var integer $paid
 */

use yii\helpers\Url;

$this->title = 'Мои счета - Личный кабинет';

$client = Yii::$app->user->identity->client;
?>
<div class="block_body">
    <div class="button-block-table">
        <a href="<?= Url::to(['', 'paid' => 0]) ?>" class="button <?= $paid == 0 ? 'active' : '' ?>">Неоплаченные</a>
        <a href="<?= Url::to(['', 'paid' => 1]) ?>" class="button <?= $paid == 1 ? 'active' : '' ?>">Оплаченные</a>
    </div>
    <div class="block_info">
        <table class="history_table" data-id=0>
            <tr class="title">
                <td>Номер счета</td>
                <td>Описание</td>
                <td>Сумма</td>
                <td></td>
            </tr>
            <?php foreach ($client->getInvoices($paid) as $invoice) : ?>
                <tr>
                    <td><?= $invoice->id ?></td>
                    <td><?= $invoice->getPaymentText() ?></td>
                    <td><?= number_format($invoice->price, 0, '.', ' ') ?> руб.<br>
                        <?php if ($invoice->paid_at == null) :?>
                            <?php if ($invoice->isChild() && $client->bonus_balance > 0): ?>
                                <a href="<?= Url::to(['/invoice/render-modal', 'id' => $invoice->id]) ?>" class="popup">Оплатить</a>
                            <?php else:?>
                                <a href="<?= Url::to(['/site/payment', 'id' => $invoice->id]) ?>">Оплатить</a>
                            <?php endif; ?>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <!-- TODO -->
        <div class="mobile-substitute-table-wrap">
            <div class="block">
                <div class="block__head">Счёт №12</div>
                <div class="block__body">
                    <div class="row-wrap">
                        <b>Описание:</b>
                        <p>Продление аренды автомобиля KIA RIO 2017 на 4 дня</p>
                    </div>
                    <div class="row-wrap">
                        <b>Описание:</b>
                        <p>Продление аренды автомобиля KIA RIO 2017 на 4 дня</p>
                    </div>
                    <div class="buttons-wrap">
                        <div class="button">Перейти к оплате</div>
                        <div class="button">Скачать счет</div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block__head">Счёт №13</div>
                <div class="block__body">
                    <div class="row-wrap">
                        <b>Описание:</b>
                        <p>Продление аренды автомобиля KIA RIO 2017 на 4 дня</p>
                    </div>
                    <div class="row-wrap">
                        <b>Описание:</b>
                        <p>Продление аренды автомобиля KIA RIO 2017 на 4 дня</p>
                    </div>
                    <div class="buttons-wrap">
                        <div class="button">Перейти к оплате</div>
                        <div class="button">Скачать счет</div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block__head">Счёт №14</div>
                <div class="block__body">
                    <div class="row-wrap">
                        <b>Описание:</b>
                        <p>Продление аренды автомобиля KIA RIO 2017 на 4 дня</p>
                    </div>
                    <div class="row-wrap">
                        <b>Описание:</b>
                        <p>Продление аренды автомобиля KIA RIO 2017 на 4 дня</p>
                    </div>
                    <div class="buttons-wrap">
                        <div class="button">Перейти к оплате</div>
                        <div class="button">Скачать счет</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>