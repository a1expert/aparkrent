<?php

use backend\models\AutoModel;
use backend\models\Car;
use backend\models\Client;
use backend\models\Reserve;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\forms\ReserveForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="reserve-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
    ]); ?>

    <?php $fieldOption = ['class' => 'form-control js-client-change'];
    if ($model->reserve->status == null) {
        $fieldOption['prompt'] = 'Новый клиент';
    } ?>

    <?= $form->field($model, 'client_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Client::find()->where(['status' => Client::STATUS_VERIFIED])->all(), 'id', 'fullNameAndPhone'),
        'options' => $fieldOption,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?php if ($model->reserve->status == null) : ?>
        <div class="js-new-client-fields">
            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'phone')->textInput(['type' => 'tel', 'class' => 'form-control js-phone-mask']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'model_id')->dropDownList(ArrayHelper::map(AutoModel::find()->orderBy('mark_id')->all(), 'id', 'fullTitle'), ['class' => 'form-control js-model-change', 'prompt' => 'Не выбрана']) ?>

    <?= $form->field($model, 'date_from')->widget(DateTimePicker::className(), [
        'convertFormat' => true,
        'pluginOptions' => [
                'autoclose' => true,
            'format' => 'dd-M-yyyy H:mm',
            'startDate' => \Yii::$app->formatter->asDateTime('NOW', 'dd-M-yyyy HH:mm'),
            'todayHighlight' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'date_to')->widget(DateTimePicker::className(), [
        'convertFormat' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-M-yyyy H:mm',
            'startDate' => \Yii::$app->formatter->asDateTime('NOW', 'dd-M-yyyy HH:mm'),
            'todayHighlight' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'car_id')->dropDownList(ArrayHelper::map(Car::find()->filterWhere(['model_id' => $model->model_id])->all(), 'id', 'number'), ['prompt' => 'Не назначена']) ?>

    <?= $form->field($model, 'price')->textInput(['disabled' => $model->paid_at != null ? true : false]) ?>

    <?= $form->field($model, 'comment')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->reserve->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->reserve->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
