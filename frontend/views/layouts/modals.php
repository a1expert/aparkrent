<?php
use frontend\forms\CallbackForm;
use yii\widgets\ActiveForm;
use frontend\forms\ReserveForm;
use frontend\assets\ReserveAsset;
use frontend\models\AdditionalService;

$callback = new CallbackForm();
$callback->title = 'Обратная связь с сайта aparkrent.ru';

$reserve = new ReserveForm();
ReserveAsset::register($this);
?>
<div id="callback-modal" class="zoom-anim-dialog mfp-hide">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'callback-form']]) ?>
        <div class="title">Обратная связь</div>
        <div class="desc">Заполните форму обратной связи и наш менеджер ответит на все интересующие вас вопросы</div>
        <div class="form">
            <?= $form->field($callback, 'title')->hiddenInput()->label(false); ?>
            <?= $form->field($callback, 'name')->textInput(['placeholder' => 'Ваше имя'])->label(false) ?>
            <?= $form->field($callback, 'email')->textInput(['placeholder' => 'Электронный адрес'])->label(false) ?>
            <?= $form->field($callback, 'message')->textarea(['placeholder' => 'Введите сообщение'])->label(false) ?>
            <div class="button-wrapper">
                <button class="button">ОТПРАВИТЬ</button>
            </div>
        </div>
        <div class="error-message"></div>
    <?php ActiveForm::end() ?>
</div>

<div id="reserve-modal" class="zoom-anim-dialog mfp-hide">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'reserve-page'],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['/reserve/validate'],
    ]) ?>
    <div class="title">Забронировать</div>
    <div class="form">
        <?= $form->field($reserve, 'model_id')->hiddenInput()->label(false); ?>
        <?= $form->field($reserve, 'price')->hiddenInput(['value' => 0, 'class' => 'js-price-input'])->label(false); ?>
        <?= $form->field($reserve, 'phone')->textInput(['class' => 'js-phone-mask', 'placeholder' => 'Телефон'])->label(false); ?>
        <?= $form->field($reserve, 'date_reserve')->textInput(['class' => 'js-date-range-picker', 'placeholder' => 'Дата аренды'])->label(false); ?>

        <label class="additional-parameters-switch">
            <input type="checkbox" name="" id="">
            <div class="check-block"></div>
            <div class="text">Дополнительные опции</div>
        </label>

        <div class="additional-parameters">
            <div class="wrap">
                <div class="block-other-jobs">
                    <div class="inputs">
                        <?php foreach (AdditionalService::find()->where(['type' => AdditionalService::TYPE_RENT])->all() as $rent):?>
                            <div class="check-other-job">
                                <?= $rent->title ?>
                                <input type="hidden" name="ReserveForm[addServices][<?= $rent->id ?>]" value="0">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <section class="price-section" id="price-section">
            <div class="price">
                <div class="num js-price">0</div>
                <div class="price-desc">
                    <div class="rouble">₽</div>
                </div>
            </div>
        </section>

        <div class="button-wrapper">
            <button class="button">ОТПРАВИТЬ</button>
        </div>
    </div>
    <div class="error-message"></div>
    <?php ActiveForm::end() ?>
</div>

<div id="reserve-success" class="zoom-anim-dialog mfp-hide">
    <div id="success"></div>
</div>