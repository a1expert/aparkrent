<?php
/**
 * Created at 05.12.2017 16:16
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \cabinet\models\Invoice $invoice
 * @var \cabinet\models\Client $client
 */

use yii\helpers\Url;

$client = Yii::$app->user->identity->client;

?>
<div class="modal-body">
    <div class="title">Оплата бонусами</div>
    <div class="quantity-bonuses">
        <div class="text">
            Доступно бонусов :
            <span class="js-bonuses-balance"><?= number_format($client->bonus_balance, 2, '.', ' ') ?></span>
        </div>
    </div>
    <div class="input-block">
        <input class="js-bonuses-field" placeholder="Введите количество" type="text" value="<?= $invoice->bonuses ?>"
               data-url="<?= Url::to(['/payment/add-bonuses', 'invoice_id' => $invoice->id, 'client_id' => $client->id]) ?>">
    </div>
    <div class="quantity-bonuses">
        <div class="text">
            Итоговая сумма :
            <span class="js-price"><?= number_format($invoice->getPriceForPayment(), 2, '.', ' ') ?></span>
        </div>
    </div>
    <a href="<?= Url::to(['/site/payment', 'id' => $invoice->id]) ?>" class="button">Оплатить</a>
    <div class="error-summary"></div>
</div>
