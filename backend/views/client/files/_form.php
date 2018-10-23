<?php
use backend\models\Client;
use backend\models\ClientFile;
use yii\widgets\ActiveForm;

/**
 * @var Client $model
 * @var ClientFile $file
 */

$form = ActiveForm::begin(['options' => ['id' => 'to-client-form']]);
?>
<?php if ($file->isNewRecord) : ?>
    <label class="btn btn-success">
        Загрузить
        <input id="fileUploader" type="file" style="display:none;"
               data-upload-url="/tools/upload-file"
               data-link-input="#link-holder"
               data-name-input="#name-holder"
               data-info=".info-file">
    </label>
<?php endif; ?>
<div class="info-file"></div>

<?= $form->field($file, 'path')->hiddenInput(['id' => 'link-holder'])->label(false) ?>

<?= $form->field($file, 'name')->textInput(['id' => 'name-holder']) ?>

<?= $form->field($file, 'client_id')->hiddenInput(['value' => $model->id])->label(false) ?>

<button class="btn btn-success">Сохранить</button>
<?php ActiveForm::end() ?>

