<?php
/**
 * Created at 25.11.2017 15:56
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \cabinet\forms\RestoreForm $model
 */
use yii\widgets\ActiveForm;

$this->title = 'Восстановление пароля';

?>
<main>
    <section class="login">
        <div class="content">
            <div class="login_body">
                <div class="text">Введите данные</div>

                <?= $this->render('_alert') ?>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                    ],
                ]); ?>

                <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Телефон', 'class' => 'js-phone-mask', 'disabled' => true])->label(false) ?>

                <?= $form->field($model, 'reset_token')->passwordInput(['placeholder' => 'Код'])->label(false) ?>

                <button>Восстановить</button>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</main>
