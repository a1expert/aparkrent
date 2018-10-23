<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AutoMark */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-mark-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(),
        [
            'name' => 'attach_logo',
            'language' => 'ru',
            'options' =>
                [
                    'accept' => 'image/*',
                    'multiple' => false
                ],
            'pluginOptions' =>
                [
                    'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary',
                    'removeClass' => 'btn btn-danger',
                    'browseLabel' => 'Выбрать',
                    'removeLabel' => 'Удалить',
                    'showCaption' => false,
                    'initialPreview' => [
                            $model->logo ? Html::img(Yii::$app->params['frontend'] . $model->logo) : null,
                    ],
                ],
        ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord):?>
        <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
