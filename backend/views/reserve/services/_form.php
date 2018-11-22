<?php
/**
 * Created at 10.10.2017 15:10
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \backend\forms\AdditionalReserveForm $service
 */

use backend\models\AdditionalService;
use backend\models\ReserveAdditionalService;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => [
        'id' => 'to-reserve-form',
    ],
    'enableClientValidation' => true,
]);
?>
<?= $form->field($service, 'reserve_id')->hiddenInput(['value' => $model->id])->label(false) ?>

<?= $form->field($service, 'type')->dropDownList(AdditionalService::getTypeArray(), ['class' => 'form-control js-type-selector']) ?>

<?= $form->field(
    $service,
    'delivery_type',
    [
        'options' => [
            'class' => 'form-group js-type-target js-type-' . AdditionalService::TYPE_DELIVERY,
            'style' => !in_array($service->type, [null, AdditionalService::TYPE_DELIVERY]) ? 'display: none' : '',
        ],
    ])->dropDownList(ReserveAdditionalService::getDeliveryTypeArray()) ?>

<?= $form->field($service, 'additional_service_id',[
    'options' => [
        'class' => 'form-group js-type-target js-type-' . AdditionalService::TYPE_DELIVERY . ' js-type-' . AdditionalService::TYPE_RENT . ' js-type-' . AdditionalService::TYPE_WASH,
        'style' => !in_array($service->type, [null, AdditionalService::TYPE_DELIVERY, AdditionalService::TYPE_RENT, AdditionalService::TYPE_WASH]) ? 'display: none' : '',
    ],
])->dropDownList(ArrayHelper::map(AdditionalService::find()->where(['type' => AdditionalService::TYPE_DELIVERY])->all(), 'id', 'title'), ['class' => 'form-control js-service-list'])->label(false) ?>

<?= $form->field(
    $service,
    'address',
    [
        'options' => [
            'class' => 'form-group js-type-target js-type-' . AdditionalService::TYPE_DELIVERY,
            'style' => !in_array($service->type, [null, AdditionalService::TYPE_DELIVERY]) ? 'display: none' : '',
        ],
    ])->textarea() ?>

    <button class="btn btn-success">Сохранить</button>
<?php ActiveForm::end() ?>