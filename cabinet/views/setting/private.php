<?php
$this->title = 'Личные настройки - Личный кабинет';

$client = Yii::$app->user->identity->client;

$disabled = true; // пока недоступно
?>
<div class="block_body" data-id=0>
    <div class="block_info">
        <?php $form = \yii\widgets\ActiveForm::begin() ?>
        <div class="block_input">
            <div class="block_name">
                <div class="num">1</div>
                Персональные данные
            </div>
            <div class="form_group">
                <div class="input_name">Телефон</div>
                <?= $form->field($client, 'phone')->textInput(['disabled' => $disabled])->label(false) ?>
            </div>
            <div class="form_group">
                <div class="input_name">Электронная почта</div>
                <?= $form->field($client, 'email')->textInput(['disabled' => $disabled])->label(false) ?>
            </div>
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
        <div class="password-block">
            <?= $this->render('_change_password', ['passwordChanger' => $passwordChanger]) ?>
        </div>
    </div>
    <!--                    <button class="save">СОХРАНИТЬ ИЗМЕНЕНИЯ</button>-->
</div>