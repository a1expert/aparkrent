<?php

use borales\extensions\phoneInput\PhoneInput;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';

?>
<main>
<section class="sign_up">
	<div class="content">
		<div class="sign_up_body">
            <?= $this->render('_alert') ?>

            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                ],
            ]); ?>

            <div class="text">Введите номер телефона для регистрации <br>
                в личном кабинете</div>

            <?= $form->field($model, 'phone')->widget(PhoneInput::className(), [
                'options' => [
//                    'class' => 'phone-inp-pd',
                    'placeholder' => 'Телефон',
                ],
                'jsOptions' => [
                    'autoHideDialCode' => false,
                    'nationalMode' => false,
                    'formatOnDisplay' => false,
                    'preferredCountries' => ['ru', 'gb', 'us'],
                ],
            ])->label(false); ?>

            <button class="regist">Зарегистрироваться</button>

            <?php ActiveForm::end(); ?>

		</div>
		<div class="sign_up_body second" style="display: none;">
			<div class="text" >Введите смс код</div>
			<input type="text" placeholder="СМС код">
			<button>Войти</button>
		</div>
	</div>
</section>
</main>