<?php
/** @var \cabinet\models\Client $client
 * @var \cabinet\models\Reserve $reserve
 */

use cabinet\models\AdditionalService;

$this->title = 'Оплата - Личный кабинет';

$client = Yii::$app->user->identity->client;

?>
<div class="block_body">
    <section class="payment">
        <div class="head-block">
            <?php if ($reserve->invoice->paid_at == null) : ?>
                <div class="name">Оплата заказа №<?= $reserve->id ?></div>
            <?php else: ?>
                <div class="name">Заказ №<?= $reserve->id ?></div>
            <?php endif; ?>
        </div>
        <div class="head-block">
            <div class="rental-date">
                <div class="text">Марка автомобиля</div>
                <div class="info">
                    <?= $reserve->model->mark->title . ' ' . $reserve->model->title ?>
                </div>
            </div>
        </div>
        <div class="head-block">
            <div class="rental-date">
                <div class="text">Дата аренды</div>
                <div class="info">
                    <span>c</span><?= Yii::$app->formatter->asDatetime($reserve->delivery_date, 'HH:mm d-M-Y') ?>
                    <span>до</span><?= Yii::$app->formatter->asDatetime($reserve->return_date, 'HH:mm d-M-Y') ?>
                </div>
            </div>
        </div>
        <div class="body-block">
            <div class="block">
                <div class="text-group">
                    <div class="name">Срок аренды</div>
                    <div class="text"><?= $reserve->getRentTimeString() ?></div>
                </div>
                <div class="text-group">
                    <div class="name">Стоимость аренды</div>
                    <div class="text"><?= number_format($reserve->getRentCost(), 0, '.', ' ') ?> ₽</div>
                </div>
                <div class="text-group">
                    <div class="name">Стоимость дополнительных услуг</div>
                    <div class="text"><?= number_format($reserve->getAdditionalCost(), 0, '.', ' ') ?> ₽</div>
                </div>
            </div>
            <div class="block">
                <?php if (!empty($reserve->reserveAdditionalServices) || !$reserve->deliveryNotInWorkTime || !$reserve->returnNotInWorkTime || !$reserve->getAdditionalHours()) : ?>
                    <?php foreach ($reserve->reserveAdditionalServices as $reserveAdditionalService) :
                        $service = $reserveAdditionalService->additionalService; ?>
                        <?php if ($service->type == AdditionalService::TYPE_DELIVERY) : ?>
                        <?php if ($reserveAdditionalService->delivery_type == \frontend\models\ReserveAdditionalService::DELIVERY_TO_CLIENT): ?>
                            <div class="text-group">
                                <div class="name"><?= 'Доставка: ' . $service->title ?></div>
                                <div class="text"><?= number_format($service->price, 0, '.', ' ') ?> ₽</div>
                            </div>
                        <?php else: ?>
                            <div class="text-group">
                                <div class="name"><?= 'Возврат: ' . $service->title ?></div>
                                <div class="text"><?= number_format($service->price, 0, '.', ' ') ?> ₽</div>
                            </div>
                        <?php endif; ?>
                    <?php elseif ($service->type == AdditionalService::TYPE_WASH): ?>
                        <div class="text-group">
                            <div class="name"><?= $service->title ?></div>
                            <div class="text"><?= number_format($service->price, 0, '.', ' ') ?> ₽</div>
                        </div>
                    <?php elseif ($service->type == AdditionalService::TYPE_RENT): ?>
                        <div class="text-group">
                            <div class="name"><?= $service->title ?></div>
                            <div class="text"><?= number_format($service->price * $reserve->daysForAdditional, 0, '.', ' ') ?>
                                ₽
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($reserve->deliveryNotInWorkTime): ?>
                        <div class="text-group">
                            <div class="name">Доставка в нерабочее время</div>
                            <div class="text">500 ₽</div>
                        </div>
                    <?php endif; ?>
                    <?php if ($reserve->returnNotInWorkTime): ?>
                        <div class="text-group">
                            <div class="name">Возврат в нерабочее время</div>
                            <div class="text">500 ₽</div>
                        </div>
                    <?php endif; ?>
                    <?php if ($reserve->getAdditionalHours()): ; ?>
                        <div class="text-group">
                            <div class="name">Оплата дополнительных часов</div>
                            <div class="text"><?= $reserve->getAdditionalHours() * 300 ?> ₽</div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-group">
                        <div class="name">Дополнительные услуги отсутствуют</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($reserve->invoice->paid_at == null) : ?>
            <?php if ($client->bonus_balance > 0): ?>
                <div class="footer-block">
                    <div class="price">Доступно бонусов:
                        <div class="js-bonuses-balance"><?= number_format($client->bonus_balance, 2, '.', ' ') ?></div>
                    </div>
                </div>
                <div class="footer-block">
                    <div class="price">Оплатить бонусами
                        <input class="js-bonuses-field"
                               data-url="<?= \yii\helpers\Url::to(['/payment/add-bonuses', 'invoice_id' => $reserve->invoice_id, 'client_id' => $client->id]) ?>"
                               value="<?= (double)$reserve->invoice->bonuses ?>"></div>
                </div>
                <div class="error-summary"></div>
            <?php endif; ?>
            <div class="footer-block">
                <div class="price">Итоговая стоимость: <span
                            class="js-price"><?= number_format($reserve->invoice->getPriceForPayment(), 2, '.', ' ') ?>
                        ₽</span></div>
                <a href="<?= \yii\helpers\Url::to(['/payment/send-to-sberbank', 'invoice_id' => $reserve->invoice->id]) ?>"
                   class="button sberbank-link">Оплатить</a>
            </div>
        <?php endif; ?>
    </section>
</div>