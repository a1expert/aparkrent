<?php

use cabinet\services\LoyaltyService;
use yii\helpers\Url;

$this->title = 'Главная - Личный кабинет';

/** @var \cabinet\models\Client $client */
$client = Yii::$app->user->identity->client;
$loyaltyService = new LoyaltyService($client);
$notPaidFines = 0;
foreach ($client->fines as $fine) {
    if ($fine->invoice->paid_at == null) {
        $notPaidFines++;
    }
}
?>
<section class="main_page">
    <div class="block_m main">
        <div class="icon_rank <?= $loyaltyService->getLoyaltyStatus() ?>"></div>
        <div class="info_block">
            <div class="top_block">
                <div class="left_block">
                    <div class="name">Статус:</div>
                    <div class="status"><?= $loyaltyService->getLoyaltyStatusName() ?></div>
                </div>
                <div class="right_block"><span><?= number_format($loyaltyService->getClientBonuses(), 0, '.', ' ') ?></span><?= \Yii::t('app', '{n, plural, one{бонус} few{бонуса} other{бонусов}}', ['n' => $loyaltyService->getClientBonuses()]) ?>
                </div>                
            </div>
            <div class="line_info">
                <div class="line_b">
                    <div class="line_exp" style="width: <?= $loyaltyService->getProgressToNextLoyaltyStatus() ?>%">
                        <div class="text"><?= number_format($loyaltyService->getPaidAmount(), 0, '.', ' ') ?> ₽</div>
                    </div>
                </div>
                <?php if ($loyaltyService->hasNextLoyaltyStatus()):?>
                    <div class="other_info">Следующий статус: <?= $loyaltyService->getNextLoyaltyStatusName() ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="block_m info">
        <div class="icon"></div>
        <div class="info_block">
            <div class="text">У вас <span><?= count($client->getInvoices(0)) ?></span> <?= \Yii::t('app', '{n, plural, one{неоплаченный счет} few{неоплаченных счета} other{неоплаченных счетов}}', ['n' => count($client->getInvoices(0))]) ?> </div>
            <a href="<?= Url::to(['/invoice/index']) ?>" class="button">ПОДРОБНЕЕ</a>
        </div>
    </div>
    <div class="block">
        <div class="img">
            <div class="i-1"></div>
        </div>
        <div class="text-block">
            <div class="title">Активные заказы</div>
            <div class="text">У вас <span><?= $client->getActiveReserveCount() ?></span> <?= \Yii::t('app', '{n, plural, one{активный заказ} few{активных заказа} other{активных заказов}}', ['n' => $client->getActiveReserveCount()]) ?> </div>
        </div>
        <a href="<?= Url::to(['/reserve/index']) ?>" class="button">ПОДРОБНЕЕ</a>
    </div>
    <div class="block">
        <div class="img">
            <div class="i-2"></div>
        </div>
        <div class="text-block">
            <div class="title">Штрафы</div>
            <?php if ($notPaidFines == 0) :?>
                <div class="text">Неоплаченных штрафов нет</div>
            <?php else: ?>
                <div class="text">У вас <span><?= $notPaidFines ?></span> <?= \Yii::t('app', '{n, plural, one{неоплаченный штраф} few{неоплаченных штрафа} other{неоплаченных штрафов}}', ['n' => $notPaidFines]) ?></div>
            <?php endif; ?>
        </div>
        <a href="<?= Url::to(['/fine/index']) ?>" class="button">ПОДРОБНЕЕ</a>
    </div>
    <div class="block">
        <div class="img">
            <div class="i-3"></div>
        </div>
        <div class="text-block">
            <div class="title">ДТП</div>
            <div class="text">Активных ДТП нет</div>
        </div>
        <a href="" class="button">ПОДРОБНЕЕ</a>
    </div>
</section>