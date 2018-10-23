<?php $form = \yii\widgets\ActiveForm::begin([
    'enableClientValidation' => true,
    'options' => [
        'id' => 'password-changer',
    ]])?>
    <div class="block_input">
        <div class="block_name">
            <div class="num">2</div>
            Вход на сайт
        </div>
        <div class="form_group">
            <div class="input_name">Текущий пароль</div>
            <?= $form->field($passwordChanger, 'password')->passwordInput()->label(false)?>
        </div>
        <div class="form_group">
            <div class="input_name">Новый пароль</div>
            <?= $form->field($passwordChanger, 'new_password')->passwordInput()->label(false)?>
        </div>
        <div class="form_group">
            <div class="input_name">Повторите новый пароль</div>
            <?= $form->field($passwordChanger, 'new_password_again')->passwordInput()->label(false)?>
        </div>
    </div>
    <div class="error-summary-message"></div>
    <button class="save">ИЗМЕНИТЬ ПАРОЛЬ</button>
<?php \yii\widgets\ActiveForm::end() ?>