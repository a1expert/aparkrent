<?php
use backend\models\AdditionalService;
use backend\models\Reserve;
use backend\models\ReserveChild;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var Reserve $model
 * @var \backend\forms\ReserveChildrenForm $childForm
 */
$formatter = Yii::$app->formatter;

$endForFrom = $childForm->date_to == null ? $model->return_date : $formatter->asTimestamp($childForm->date_to);

$rentTypes = AdditionalService::find()->select('id')->where(['type' => AdditionalService::TYPE_RENT])->column();

$form = ActiveForm::begin([
    'options' => [
        'id' => 'to-reserve-form',
        'class' => 'js-child-form',
        'data' => [
            'reserve-id' => $model->id,
            'child-id' => $childForm->child->id,
        ]
    ],
    'action' => $childForm->child->isNewRecord ? '/reserve-child/create?id=' . $model->id : '/reserve-child/update?id=' . $childForm->child->id,
]);
?>

<?= $form->field($childForm, 'type')->dropDownList(ReserveChild::getTypeArray()) ?>

<?= $form->field($childForm, 'reserve_id')->hiddenInput(['value' => $model->id])->label(false) ?>

<?= $form->field($childForm, 'price')->textInput() ?>
<?php if ($childForm->type == ReserveChild::TYPE_ADDITIONAL_SERVICE_FOR_TIME) :?>

    <?= $form->field($childForm, 'service_id')->dropDownList(
        ArrayHelper::map(
            AdditionalService::find()
                ->all(), 'id', 'fullTitle')) ?>

    <?php if (in_array($childForm->service_id, $rentTypes)  && $childForm->service_id != null) : ?>

        <?= $form->field($childForm, 'date_from')->widget(DateTimePicker::className(), [
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'startDate' => $formatter->asDateTime($model->delivery_date, 'dd-M-yyyy HH:mm'),
                'endDate' => $formatter->asDateTime($endForFrom, 'dd-M-yyyy HH:mm'),
                'format' => 'dd-M-yyyy H:mm',
            ],
            'options' => [
                'value' => $childForm->date_from != ''
                    ? $childForm->date_from
                    : ($childForm->child->isNewRecord
                        ? $formatter->asDateTime($model->delivery_date, 'dd-M-yyyy HH:mm')
                        : $childForm->date_from),
            ],
        ]) ?>
    <?php endif; ?>

<?php endif; ?>

<?php if (in_array($childForm->type, [null, ReserveChild::TYPE_PROLONGATION])  || (in_array($childForm->service_id, $rentTypes)  && $childForm->service_id != null)) : ?>

    <?= $form->field($childForm, 'date_to')->widget(DateTimePicker::className(), [
        'convertFormat' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'startDate' => $formatter->asDateTime($model->return_date, 'dd-M-yyyy HH:mm'),
            'format' => 'dd-M-yyyy H:mm',
        ],
        'options' => [
            'value' => $childForm->date_to != ''
                ? $childForm->date_to
                : ($childForm->child->isNewRecord
                    ? $formatter->asDateTime($model->return_date, 'dd-M-yyyy HH:mm')
                    : $childForm->date_to),
        ],
    ]) ?>

<?php endif; ?>

<button class="btn btn-success">Сохранить</button>
<?php ActiveForm::end() ?>

