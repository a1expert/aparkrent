<?php
use backend\models\DefectDamage;
use backend\models\DefectDegree;
use backend\models\DefectPlace;
use backend\models\DefectSize;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @var \backend\models\Defect $defect
 */

$form = ActiveForm::begin(['options' => ['id' => 'to-car-form']]);
?>
<?= $form->field($defect, 'car_id')->hiddenInput()->label(false) ?>

<?= $form->field($defect, 'place_id')->widget(Select2::className(), [
    'data' => ArrayHelper::map(DefectPlace::find()->all(), 'id', 'title'),
]) ?>

<?= $form->field($defect, 'size_id')->dropDownList(ArrayHelper::map(DefectSize::find()->all(), 'id', 'title')) ?>

<?= $form->field($defect, 'degree_id')->dropDownList(ArrayHelper::map(DefectDegree::find()->all(), 'id', 'title')) ?>

<?= $form->field($defect, 'damage_id')->dropDownList(ArrayHelper::map(DefectDamage::find()->all(), 'id', 'title')) ?>

<button class="btn btn-success">Сохранить</button>
<?php ActiveForm::end() ?>

