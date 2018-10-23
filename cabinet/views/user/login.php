<?php
use cabinet\forms\LoginForm;
use yii\widgets\ActiveForm;

$this->title = 'Вход';

/** @var LoginForm $model */

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

                <?= $form->field($model, 'login')->textInput(['placeholder' => 'Телефон или E-mail'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

                <button>Вход</button>

                <a href="<?= \yii\helpers\Url::to(['/user/restore']) ?>" class="sign_up">Восстановить пароль</a>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</main>