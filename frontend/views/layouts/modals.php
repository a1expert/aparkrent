<?php
use frontend\forms\CallbackForm;
use yii\widgets\ActiveForm;

$callback = new CallbackForm();
$callback->title = 'Обратная связь с сайта aparkrent.ru';
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