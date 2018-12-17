<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-mark-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title_1')->textInput() ?>

    <?= $form->field($model, 'title_2')->textInput() ?>

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
                    'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary',
                    'removeClass' => 'btn btn-danger',
                    'browseLabel' => 'Выбрать',
                    'removeLabel' => 'Удалить',
                    'showCaption' => false,
                    'previewSettings' => [
                        'image' => ['width' => "100px", 'height' => "100px"],
                        'html' => ['width' => "150px", 'height' => "100px"],
                        'other' => ['width' => "150px", 'height' => "100px"]
                    ],
                    'initialPreview' => [
                            $model->image ? Html::img(Yii::$app->params['frontend'] . $model->image) : null,
                    ],
                ],
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
