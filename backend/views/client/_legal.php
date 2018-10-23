<?php
/**
 * Created at 09.10.2017 15:10
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
?>
<?= $form->field($model, 'inn')->textInput(['maxlength' => true, 'class' => 'form-control js-inn']) ?>

<?= $form->field($model, 'kpp')->textInput(['maxlength' => true, 'class' => 'form-control js-kpp']) ?>

<?= $form->field($model, 'ogrn')->textInput(['maxlength' => true, 'class' => 'form-control js-ogrn']) ?>

<?= $form->field($model, 'account_number')->textInput(['maxlength' => true, 'class' => 'form-control js-account-number']) ?>

<?= $form->field($model, 'bik')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'correspondent_account')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'company_residence')->textInput(['maxlength' => true, 'class' => 'form-control js-company-address']) ?>

<?= $form->field($model, 'post_in_company')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'fio_for_paper')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'company_phone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'company_email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'name_for_signature')->textInput(['maxlength' => true]) ?>