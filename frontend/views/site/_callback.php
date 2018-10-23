<?php

use frontend\forms\CallbackForm;
use yii\widgets\ActiveForm;

$callback = new CallbackForm();
$callback->title = 'Обратная связь с сайта aparkrent.ru';

?>
<!--noindex-->
<section class="callback-section">
	<div class="content">
		<div class="text-block">
			<div class="name">ОБРАТНАЯ СВЯЗЬ</div>
			<div class="desc">
				ВОЗНИКЛИ ВОПРОСЫ?<br>
				ПОЛУЧИТЕ БЕСПЛАТНУЮ КОНСУЛЬТАЦИЮ!
			</div>
		</div>
		<div class="form-block">
			<div class="desc">Заполните форму обратной связи и наш менеджер ответит на все интересующие вас вопросы</div>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'callback-form']]) ?>
                <?= $form->field($callback, 'title')->hiddenInput()->label(false); ?>
                <?= $form->field($callback, 'name')->textInput(['placeholder' => 'Ваше имя'])->label(false) ?>
                <?= $form->field($callback, 'email')->textInput(['placeholder' => 'Электронный адрес'])->label(false) ?>
                <?= $form->field($callback, 'message')->textarea(['placeholder' => 'Введите сообщение'])->label(false) ?>
				<div class="button-wrapper">
					<button class="button">ОТПРАВИТЬ</button>
				</div>
            <div class="error-message"></div>
            <?php ActiveForm::end() ?>
		</div>
	</div>
</section>
<!--/noindex-->
