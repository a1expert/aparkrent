<?php
/**
 * Created at 28.10.2017 13:38
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
$client = Yii::$app->user->identity->client;
?>
<div class="menu_left">
    <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>"
       class="name <?= Yii::$app->controller->id == 'site' ? 'active' : '' ?>">
        Главная страница
    </a>
    <a href="<?= \yii\helpers\Url::to(['/reserve/index']) ?>"
       class="name <?= Yii::$app->controller->id == 'reserve' ? 'active' : '' ?>">
        Мои заказы
    </a>
    <a href="<?= \yii\helpers\Url::to(['/invoice/index']) ?>"
       class="name <?= Yii::$app->controller->id == 'invoice' ? 'active' : '' ?>">
        Мои счета <?= count($client->getInvoices(0)) > 0 ? '<div class="num">' . count($client->getInvoices(0)) . '</div>' : '' ?>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/fine/index']) ?>"
       class="name <?= Yii::$app->controller->id == 'fine' ? 'active' : '' ?>">
        Штрафы ПДД
    </a>
    <div class="a-block <?= Yii::$app->controller->id == 'setting' ? 'open' : '' ?>">
        <div class="a-head">Настройки</div>
        <div class="a-body" <?= Yii::$app->controller->id == 'setting' ? '' : 'style="display: none"' ?>>
            <a href="<?= \yii\helpers\Url::to(['/setting/personal']) ?>"
               class="name <?= Yii::$app->controller->action->id == 'personal' ? 'active' : '' ?>">
                Личные настройки
            </a>
            <a href="<?= \yii\helpers\Url::to(['/setting/private']) ?>"
               class="name <?= Yii::$app->controller->action->id == 'private' ? 'active' : '' ?>">
                Приватные настройки
            </a>
        </div>
    </div>
</div>
