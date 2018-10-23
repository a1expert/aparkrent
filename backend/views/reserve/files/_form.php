<?php
use backend\models\Reserve;
use backend\models\ReserveFile;
use backend\models\ReserveFileType;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var Reserve $model
 *  @var ReserveFile $file
 */

$form = ActiveForm::begin(['options' => ['id' => 'to-reserve-form']]);
$types = ReserveFileType::find()->where(['legal_type' => $model->client->type])->orWhere(['legal_type' => null])->all();
?>

<?= $form->field($file, 'path')->hiddenInput(['id' => 'link-holder'])->label(false) ?>

<?= $form->field($file, 'name')->textInput(['id' => 'name-holder']) ?>

<?= $form->field($file, 'reserve_id')->hiddenInput(['value' => $model->id])->label(false) ?>

<?= $form->field($file, 'type_id')->dropDownList(ArrayHelper::map($types, 'id', 'title')) ?>

<?php if ($file->isNewRecord) : ?>
    <label class="btn btn-success">
        Загрузить
        <input id="fileUploader" type="file" style="display:none;"
               data-upload-url="/tools/upload-file"
               data-link-input="#link-holder"
               data-name-input="#name-holder"
               data-info=".info-file">
    </label>
    <div class="btn btn-success js-generate-file" data-url="<?= Url::to(['/generate/generate', 'reserve_id' => $model->id]) ?>">Сгенерировать</div>
    <div class="info-file"></div>
<?php endif; ?>
<br>

<button class="btn btn-success">Сохранить</button>
<?php ActiveForm::end() ?>

