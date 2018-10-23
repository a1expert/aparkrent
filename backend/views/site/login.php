<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\forms\LoginForm */

use backend\assets\LoginAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

LoginAsset::register($this);

$this->title = 'Вход';
?>
<div id="container">
    <div class="inPage">
        <div class="inPage-block lkForm lkLogIn">
            <a href="/login" class="inPage-logo"></a>
            <div class="inPageF">
                <div class="lkFormTop">LOGIN</div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal', 'action' => 'login', 'method' => 'post']); ?>
                    <div class="inPageForm">
                        <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'class' => 'js-phone-mask']) ?>
                    </div>
                    <div class="inPageForm">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                    <div class="form-group field-loginform-rememberme">
                        <div class="checkbox">
                            <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        </div>
                    </div>
                    <div class="form-group"></div>
                    <?= Html::a('Вернуться на сайт', Yii::$app->params['frontend']) ?>
                    <?= Html::submitButton('Вход', ['class' => 'inPageBtn', 'tabindex' => '3']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
