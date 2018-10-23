<?php
/**
 * Created at 06.10.2017 15:14
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var Reserve $model
 * @var Fine $fine
 */
use backend\models\Fine;
use backend\models\Reserve;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['options' => ['id' => 'to-reserve-form']]);
?>
<?php if ($fineForm->image == null) : ?>
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

<?= $form->field($fineForm, 'image')->hiddenInput(['id' => 'link-holder'])->label(false) ?>

<?= $form->field($fineForm, 'reserve_id')->hiddenInput(['value' => $model->id])->label(false) ?>

<?= $form->field($fineForm, 'resolution_number')->textInput() ?>

<?= $form->field($fineForm, 'paragraph')->textInput() ?>

<?= $form->field($fineForm, 'date')->textInput([
    'class' => 'form-control datepicker',
    'value' => $fineForm->date,
]) ?>
<?php
$offPrice = [];
if ($fineForm->fine != null && $fineForm->fine->invoice->paid_at) {
    $offPrice['disabled'] = 'disabled';
}
?>
<?= $form->field($fineForm, 'price')->textInput($offPrice) ?>

    <button class="btn btn-success">Сохранить</button>
<?php ActiveForm::end() ?>