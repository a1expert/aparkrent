<?php

use backend\models\Client;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Client */
/* @var $form yii\widgets\ActiveForm */
\backend\assets\ClientAsset::register($this);
?>
<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="link-selectors">
        <div data-target="#info" class="link-selector active">Общая информация</div>
        <div data-target="#special" class="link-selector">Дополнительные поля</div>
    </div>
    <div class="link-target active" id="info">
        <?php if ($model->type == Client::TYPE_INDIVIDUAL) :?>
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php if ($model->type == Client::TYPE_INDIVIDUAL) :?>
            <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>

        <?php if ($model->type == Client::TYPE_LEGAL) :?>
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'class' => 'form-control js-company-name']) ?>
        <?php endif; ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'js-phone-mask form-control']) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    </div>

    <div class="js-special-fields link-target" id="special">
        <?= $this->render($model->type == Client::TYPE_LEGAL ? '_legal' : '_individual', [
            'form' => $form,
            'model' => $model,
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
