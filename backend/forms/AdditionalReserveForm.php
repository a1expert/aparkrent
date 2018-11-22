<?php
/**
 * Created at 10.10.2017 20:55
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\forms;

use backend\models\AdditionalService;
use backend\models\ReserveAdditionalService;
use yii\base\Model;

class AdditionalReserveForm extends Model
{
    public $type;
    public $delivery_type;
    public $additional_service_id;
    public $address;
    public $reserve_id;

    public function rules()
    {
        return [
            [['type', 'reserve_id'], 'required'],
            [['type', 'delivery_type', 'additional_service_id', 'reserve_id'], 'integer'],
            [['address'], 'string'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        switch ($this->type) {
            case AdditionalService::TYPE_DELIVERY:
                return $this->saveDelivery();
            case AdditionalService::TYPE_WASH:
                return $this->saveWash();
            case AdditionalService::TYPE_RENT:
                return $this->saveRent();
            default:
                return false;
        }
    }

    public function saveDelivery()
    {
        $currentService = ReserveAdditionalService::findOne(['reserve_id' => $this->reserve_id, 'delivery_type' => $this->delivery_type]);
        if ($currentService != null) {
            $this->addError('delivery_type', 'Данная услуга уже прикреплена к резерву');
            return false;
        }
        $currentService = new ReserveAdditionalService();
        $currentService->reserve_id = $this->reserve_id;
        $currentService->additional_service_id = $this->additional_service_id;
        $currentService->delivery_type = $this->delivery_type;
        $currentService->address = $this->address;
        if ($currentService->save()) {
            return true;
        }
        return false;
    }

    public function saveWash()
    {
//        $washService = AdditionalService::findOne(['type' => AdditionalService::TYPE_WASH]);
//        $currentService = ReserveAdditionalService::findOne(['reserve_id' => $this->reserve_id, 'additional_service_id' => $washService->id]);
        $currentService = ReserveAdditionalService::findOne(['reserve_id' => $this->reserve_id, 'additional_service_id' => $this->additional_service_id]);
        if ($currentService != null) {
            $this->addError('type', 'Данная услуга уже прикреплена к резерву');
            return false;
        }
        $currentService = new ReserveAdditionalService();
        $currentService->reserve_id = $this->reserve_id;
        $currentService->additional_service_id = $this->additional_service_id;
        if ($currentService->save()) {
            return true;
        }
        return false;
    }

    public function saveRent()
    {
        $currentService = ReserveAdditionalService::findOne(['reserve_id' => $this->reserve_id, 'additional_service_id' => $this->additional_service_id]);
        if ($currentService != null) {
            $this->addError('additional_service_id', 'Данная услуга уже прикреплена к резерву');
            return false;
        }
        $currentService = new ReserveAdditionalService();
        $currentService->reserve_id = $this->reserve_id;
        $currentService->additional_service_id = $this->additional_service_id;
        if ($currentService->save()) {
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Тип услуги',
            'delivery_type' => 'Тип транспортировки',
            'additional_service_id' => '',
            'reserve_id' => '',
            'address' => 'Конкретный адрес',
        ];
    }
}