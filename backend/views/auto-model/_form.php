<?php

use backend\models\AutoClass;
use backend\models\AutoMark;
use backend\models\AutoModel;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AutoModel */
/* @var $form yii\widgets\ActiveForm */
\backend\assets\vendor\CropperAsset::register($this);
?>
<style>
    img {
        max-height: 230px;
    }
</style>

<div class="auto-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(),
        [
            'name' => 'attach_logo',
            'language' => 'ru',
            'options' =>
                [
                    'id' => 'file-for-crop',
                    'accept' => 'image/*',
                    'multiple' => false
                ],
            'pluginOptions' =>
                [
                    'allowedFileExtensions' => ['jpeg', 'png', 'ico', 'jpg', 'gif'],
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary',
                    'removeClass' => 'btn btn-danger',
                    'browseLabel' => 'Выбрать',
                    'removeLabel' => 'Удалить',
                    'showCaption' => false,
                    'previewSettings' => [
                        'image' => ['width' => "400px", 'height' => "auto"],
                        'html' => ['width' => "150px", 'height' => "auto"],
                        'other' => ['width' => "150px", 'height' => "auto"]
                    ],
                    'initialPreview' => [
                        $model->image ? Html::img(Yii::$app->params['frontend'] . $model->image) : null,
                    ],
                ],
        ]); ?>

    <?= $form->field($model, 'cropX')->hiddenInput(['id' => 'cropX'])->label(false) ?>
    <?= $form->field($model, 'cropY')->hiddenInput(['id' => 'cropY'])->label(false) ?>
    <?= $form->field($model, 'cropWidth')->hiddenInput(['id' => 'cropWidth'])->label(false) ?>
    <?= $form->field($model, 'cropHeight')->hiddenInput(['id' => 'cropHeight'])->label(false) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mark_id')->dropDownList(ArrayHelper::map(AutoMark::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'equipment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_id')->dropDownList(ArrayHelper::map(AutoClass::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'status')->dropDownList(AutoModel::$statuses) ?>

    <?= $form->field($model, 'visibility')->dropDownList(AutoModel::$visibilities) ?>

    <h1>Характеристики</h1>

    <?= $form->field($model, 'engine')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conditioner')->checkbox() ?>

    <?= $form->field($model, 'climate_control')->checkbox() ?>

    <?= $form->field($model, 'heating')->checkbox() ?>

    <?= $form->field($model, 'transmission')->dropDownList(AutoModel::$transmissions, ['prompt' => 'Не задано']) ?>

    <?= $form->field($model, 'audio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
