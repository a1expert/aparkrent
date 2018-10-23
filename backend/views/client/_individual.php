<?php
/**
 * Created at 09.10.2017 15:10
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \backend\models\Client $model
 */
?>
<?=
$form->field($model, 'birthday_string')->textInput([
    'class' => 'datepicker form-control',
    'value' => $model->birthday != null ? Yii::$app->formatter->asDate($model->birthday, 'd-M-Y') : '',
]) ?>

<?= $form->field($model, 'birthday')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'passport_series')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'passport_number')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'passport_date_issue_string')->textInput([
    'class' => 'datepicker form-control',
    'value' => $model->passport_date_issue != null ? Yii::$app->formatter->asDate($model->passport_date_issue, 'd-M-Y') : '',
]) ?>

<?= $form->field($model, 'passport_date_issue')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'passport_place_issue')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'registration_place')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'residence_place')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'additional_phone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'relative_phone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'drive_license_series')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'drive_license_number')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'drive_license_issue_date_string')->textInput([
    'class' => 'datepicker form-control',
    'value' => $model->drive_license_issue_date != null ? Yii::$app->formatter->asDate($model->drive_license_issue_date, 'd-M-Y') : '',
]) ?>