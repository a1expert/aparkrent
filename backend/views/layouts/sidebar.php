<?php

use backend\assets\NavAsset;
use backend\models\Client;
use backend\models\Reserve;
use cabinet\models\ClientChange;

NavAsset::register($this);
/**@var boolean $admin */
?>

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="<?= yii\helpers\Url::to(['/reserve/index']); ?>">
                Заявки <div class="warning-number <?= Reserve::find()->where(['status' => Reserve::STATUS_NEW])->count() > 0 ? 'active' : '' ?>"><?= Reserve::find()->where(['status' => Reserve::STATUS_NEW])->count() ?></div>
            </a>
        </li>
        <li>
            <a href="<?= yii\helpers\Url::to(['/reserve/lead']); ?>">
                Сделки
            </a>
        </li>
        <li>
            <a href="<?= yii\helpers\Url::to(['/client/index', 'ClientSearch[type]' => Client::TYPE_INDIVIDUAL]); ?>">
                Клиенты <div class="warning-number <?= Client::find()->where(['status' => Client::STATUS_NOT_VERIFIED])->count() > 0 ? 'active' : '' ?>"><?= Client::find()->where(['status' => Client::STATUS_NOT_VERIFIED])->count() ?></div>
            </a>
        </li>
        <li>
            <a href="<?= yii\helpers\Url::to(['/client-change/index']); ?>">
                Изменения клиентов <div class="warning-number <?= ClientChange::find()->count() > 0 ? 'active' : '' ?>"><?= ClientChange::find()->count() ?></div>
            </a>
        </li>
        <li>
            <a href="<?= yii\helpers\Url::to(['/car/index']); ?>">
                Автомобили
            </a>
        </li>
        <li class="<?= in_array(Yii::$app->controller->id, ['car', 'auto-mark', 'auto-model', 'tariff', 'auto-class', 'additional-service', 'faq']) ? 'open-list' : ''?>">
            <a class="open-button" data-open="#administration">
                Администирование
            </a>
            <ul id="administration" <?= in_array(Yii::$app->controller->id, ['auto-mark', 'auto-model', 'tariff', 'auto-class', 'additional-service', 'faq']) ? '' : 'style="display: none"'?>>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/auto-mark/index']); ?>">
                        <!--                <i class="glyphicon glyphicon-car"></i>-->
                        Марки
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/auto-model/index']); ?>">
                        <!--                <i class="glyphicon glyphicon-user"></i>-->
                        Модели
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/tariff/index']); ?>">
                        <!--                <i class="glyphicon glyphicon-user"></i>-->
                        Тарифы
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/auto-class/index']); ?>">
                        <!--                <i class="glyphicon glyphicon-user"></i>-->
                        Классы
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/additional-service/index']); ?>">
                        Дополнительные услуги
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/faq/index']); ?>">
                        FAQ
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/banner/index']); ?>">
                        Баннеры
                    </a>
                </li>
            </ul>
        </li>
        <li class="<?= Yii::$app->controller->id == 'archive' ? 'open-list' : ''?>">
            <a class="open-button" data-open="#archive">
                Архив
            </a>
            <ul id="archive" <?= Yii::$app->controller->id == 'archive' ? '' : 'style="display: none"'?>>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/archive/reserve']); ?>">
                        Заявки
                    </a>
                </li>
                <li>
                    <a href="<?= yii\helpers\Url::to(['/archive/lead']); ?>">
                        Сделки
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>




