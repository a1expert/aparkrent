<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Banner;

/* @var $this yii\web\View */
/* @var $model backend\models\Banner */
/* @var $form yii\widgets\ActiveForm */

\backend\assets\vendor\CropperAsset::register($this);
$this->registerJs(
    '
params = {
imageWidth: ' . Banner::IMAGE_WIDTH . ',
imageHeight: ' . Banner::IMAGE_HEIGHT . ',
url: "' . \yii\helpers\Url::to(['/site/crop']) . '",
imageHolder: $("#savingImage"),
imageLinkHolder: $("#savingImageLink"),
originalImageLinkHolder: $("#originalImageLink"),
cropperImageHolder: $("#imageCrop"),
cropperImagePreviewHolder: $("#imagePreview"),
uploadInput: $("#inputImage"),
saveButton: $("#saveImage"),
imageContainer: $("#cropped-image-container")
};
cropperInit(params);
', \yii\web\View::POS_END);
?>
<div class="auto-mark-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title_1')->textInput() ?>

    <?= $form->field($model, 'title_2')->textInput() ?>

    <div>
        <label for="">Изображение</label>
        <div>
            <?= Html::img($model->getImageFrontEnd(), ['id' => 'savingImage','style'=>'max-width:100%;height:auto']); ?>
        </div>
        <br>
        <label title="Upload image file" for="inputImage">
            <input type="file" accept="image/*" name="file" id="inputImage" class="">
        </label>
        <?= $form->field($model, 'image')->hiddenInput(['id' => 'savingImageLink'])->label(false); ?>
    </div>
    <div id="cropped-image-container">
        <img id="imageCrop" src="" style="max-width: 100%">
        <div class="col-md-12">
            Предпросмотр
            <div id="imagePreview"
                 style="height:150px; overflow: hidden;text-align: center;width: 100%; "></div>
        </div>
        <button type="button" id="saveImage">Сохранить изображение</button>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
