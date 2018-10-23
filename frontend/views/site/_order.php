<?php
/** @var \frontend\models\Reserve $reserve */
use common\components\FileHelper;
use frontend\models\AdditionalService;
use frontend\models\ReserveAdditionalService;
// TODO неиспользуется, удалить при успешном переносе оплаты
?>
<section class="online-pay-info">
    <div class="content">
        <div class="info-block">
            <div class="general-info">
                <div class="color-block" style="background: <?= $reserve->model->mark->color ?>"></div>
                <div class="logo"></div>
                <div class="info">
                    <div class="image">
                        <img src="<?= FileHelper::getImageThumb($reserve->model->image, 172, 100) ?>" alt="">
                    </div>
                    <div class="title"><?= $reserve->model->mark->title . ' ' . $reserve->model->title?></div>
                </div>
                <div class="reserve-dates">
                    <span class="name">Дата аренды</span>
                    <span>с <strong><?= Yii::$app->formatter->asDatetime($reserve->delivery_date, 'h:mm d-M-Y') ?></strong></span>
                    <span>до <strong><?= Yii::$app->formatter->asDatetime($reserve->return_date, 'h:mm d-M-Y') ?></strong></span>
                </div>
            </div>
            <div class="other-info">
                <div class="block">
                    <div class="info-wrapper">
                        <div class="name">Заказчик</div>
                        <div class="desc"><?= $reserve->client->fullName ?></div>
                    </div>
                    <div class="info-wrapper">
                        <div class="name">Телефон</div>
                        <div class="desc"><?= $reserve->client->phone ?></div>
                    </div>
                    <div class="info-wrapper">
                        <div class="name">E-mail</div>
                        <div class="desc"><?= $reserve->client->email ?></div>
                    </div>
                </div>
                <div class="block">
                    <div class="info-wrapper">
                        <div class="name">Срок аренды</div>
                        <div class="desc"><?= \Yii::t('app', '{n, plural, one{# сутки} few{# суток} many{# суток} other{# суток}}', ['n' => $reserve->days]) ?></div>
                    </div>
                    <div class="info-wrapper">
                        <div class="name">Стоимость аренды</div>
                        <div class="desc"><?= number_format($reserve->rentCost, 0, '.', ' ') ?> ₽</div>
                    </div>
                    <div class="info-wrapper">
                        <div class="name">Стоимость дополнительных услуг</div>
                        <div class="desc"><?= number_format($reserve->additionalCost, 0, '.', ' ') ?> ₽</div>
                    </div>
                </div>
            </div>
            <div class="pay-total">
                <div class="block">
                    <div class="options">
                        <?php if (!empty($reserve->reserveAdditionalServices)) : ?>
                            <?php foreach ($reserve->reserveAdditionalServices as $reserveAdditionalService) :
                                $service = $reserveAdditionalService->additionalService;?>
                                <?php if ($service->type == AdditionalService::TYPE_DELIVERY) :?>
                                    <?php if($reserveAdditionalService->delivery_type == ReserveAdditionalService::DELIVERY_TO_CLIENT):?>
                                        <div class="option"><?= 'Доставка: ' . $service->title ?><span><?= number_format($service->price, 0, '.', ' ') ?> ₽</span></div>
                                    <?php else:?>
                                        <div class="option"><?= 'Возврат: ' . $service->title ?><span><?= number_format($service->price, 0, '.', ' ') ?> ₽</span></div>
                                    <?php endif;?>
                                <?php elseif($service->type == AdditionalService::TYPE_WASH): ?>
                                    <div class="option"><?= $service->title ?><span><?= number_format($service->price, 0, '.', ' ') ?> ₽</span></div>
                                <?php elseif($service->type == AdditionalService::TYPE_RENT): ?>
                                    <div class="option"><?= $service->title ?><span><?= number_format($service->price * $reserve->days, 0, '.', ' ') ?> ₽</span></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if ($reserve->deliveryNotInWorkTime):?>
                                <div class="option">Доставка в нерабочее время<span>0 ₽</span></div>
                            <?php endif; ?>
                            <?php if ($reserve->returnNotInWorkTime):?>
                                <div class="option">Возврат в нерабочее время<span>0 ₽</span></div>
                            <?php endif; ?>
                            <?php if ($reserve->additionalHours): ;?>
                                <div class="option">Оплата дополнительных часов<span><?= $reserve->additionalHours * 300 ?> ₽</span></div>
                            <?php endif; ?>
                        <?php else:?>
                            <div class="option">Дополнительные услуги отсутствуют</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="block">
                    <div class="end-price">
                        Итоговая стоимость:
                        <span style="margin-left: 15px"><span id="end-price"><?= number_format($reserve->invoice->price, 0, '.', ' ') ?></span> ₽</span>
                    </div>
                    <a href="<?= \yii\helpers\Url::to(
                        $sberbankLink == null && $reserve->sberbank_id != null && $reserve->paid_at == null
                                ? 'https://3dsec.sberbank.ru/payment/merchants/aparkrent/payment_ru.html?mdOrder=' . $reserve->sberbank_id
                                : $sberbankLink) ?>" class="button">ОПЛАТИТЬ</a>
                </div>
            </div>
        </div>
    </div>
</section>