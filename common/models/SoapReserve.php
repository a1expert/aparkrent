<?php

namespace common\models;

use yii\base\Model;

class SoapReserve extends Model
{
    /**
     * @param $reserve Reserve
     * @param $delivery_type_id
     * @throws \yii\base\InvalidConfigException
     */
    public function xmlExport($reserve, $delivery_type_id)
    {
        $reserveAdditionalService = ReserveAdditionalService::findAll(['reserve_id' => $reserve->id]);
        $reserveToXml = [
            [
                'tag' => 'AllReserve',
                'elements' => [
                    [
                        'tag' => 'ReserveCar',
                        'attributes' => [
                            'ReserveId' => $reserve->id,
                            'ModelCode' => $reserve->model->code,
                            'ModelId' => $reserve->model->id,
                            'Model' => $reserve->model->title,
                            'DeliveryDate' => \Yii::$app->formatter->asDatetime($reserve->delivery_date,'YMMddHHiss'),
                            'ReturnDate' => \Yii::$app->formatter->asDatetime($reserve->return_date, 'YMMddHHiss'),
                            'Phone' => $reserve->client->phone,
                            'Price' => $reserve->invoice->price,
                            'Status' => $this->getStatus($reserve->status),
                            'LeadStatus' => $this->getLeadStatus($reserve->status, $reserve->lead_status),
                            'Source' => $this->getSource($reserve->source),
                        ],
                        'elements' => [
                            [
                                'tag' => 'AdditionalServices',
                                'attributes' => [
                                    'Region' => $this->getDeliveryRegion($delivery_type_id),
                                    'Address' => $this->getDeliveryAddress($reserve->id, $delivery_type_id),
                                    'Time' => $this->getDeliveryTime($reserve->id),
                                ],
                            ],
                            [
                                'tag' => 'OptionalEquipment',
                                'attributes' => [
                                    'AirportSurgut' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_AIRPORT),
                                    'RailwayStation' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_RAILWAY_STATION),
                                    'DeliveryCity' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_CITY),
                                    'Nefteyugansk' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_NEFTEYUGANSK),
                                    'KhantyMansiysk' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_KNATYMANSIYSK),
                                    'Nizhnevartovsk' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_NIZHNEVARTOVSK),
                                    'Noyabrsk' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_NOYABRSK),
                                    'NovyUrengoy' => $this->getOption($reserveAdditionalService, AdditionalService::REGION_NOVYURENGOY),
                                    'FullCarWash' => $this->getOption($reserveAdditionalService, AdditionalService::SERVICE_FULL_CAR_WASH),
                                    'VideoRecorder' => $this->getOption($reserveAdditionalService, AdditionalService::SERVICE_VIDEO_RECORDER),
                                    'Navigator' => $this->getOption($reserveAdditionalService, AdditionalService::SERVICE_NAVIGATOR),
                                    'BabySeat' => $this->getOption($reserveAdditionalService, AdditionalService::SERVICE_BABY_SEAT),
                                    'ExpressWash' => $this->getOption($reserveAdditionalService, AdditionalService::SERVICE_EXPRESS_CAR_WASH),
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ];

        $request = (new \bupy7\xml\constructor\XmlConstructor())->fromArray($reserveToXml)->toOutput();
        file_put_contents(\Yii::getAlias('@console/data/reserve.xml'), $request . PHP_EOL, FILE_NO_DEFAULT_CONTEXT);
    }

    /**
     * @param $reserveAdditionalService
     * @param $option_id
     * @return string
     */
    private function getOption($reserveAdditionalService, $option_id) {
        foreach ($reserveAdditionalService as $value) {
            if ($value->additional_service_id == $option_id) {
                return 'да';
            }
        }
        return 'нет';
    }

    /**
     * @param $status
     * @param $lead_status
     * @return string
     */
    private function getLeadStatus($status, $lead_status) {
        if ($status == Reserve::STATUS_ACCEPTED) {
            return $lead_status == Reserve::LEAD_STATUS_OPEN ? 'Открыта' : 'Закрыта';
        }
        return '';
    }

    /**
     * @param $status
     * @return string
     */
    private function getStatus($status) {
        switch ($status) {
            case Reserve::STATUS_NEW: $status = 'Новая заявка';
                break;
            case Reserve::STATUS_ACCEPTED: $status = 'Одобрено';
                break;
            case Reserve::STATUS_REJECTED: $status = 'Отказано';
                break;
            case Reserve::STATUS_DELETED: $status = 'Удалено';
                break;
        }
        return $status;
    }

    /**
     * @param $source
     * @return string
     */
    private function getSource($source) {
        return $source == Reserve::SOURCE_SITE ? 'С сайта' : 'Добавил менеджер';
    }

    /**
     * @param $delivery_type_id
     * @return string
     */
    private function getDeliveryRegion($delivery_type_id) {
        $item = AdditionalService::findOne(['id' => $delivery_type_id]);
        return !empty($item) ? $item->title : 'Офис компании';
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    private function getDeliveryTime($id) {
        $item = ReserveAdditionalService::findOne(['reserve_id' => $id]);
        return !empty($item->time) ? \Yii::$app->formatter->asDatetime($item->time, 'HH:i') : '09:00';
    }

    /**
     * @param $id
     * @param $delivery_type_id
     * @return string
     */
    private function getDeliveryAddress($id, $delivery_type_id) {
        $item = ReserveAdditionalService::findOne(['reserve_id' => $id]);
        return !empty($item->address) ? $item->address : ($delivery_type_id == '' ? 'Югорский тракт 1 к.1' : '');

    }

    public function soapExport()
    {
        $data = file_get_contents(\Yii::getAlias('@console/data/reserve.xml'));
        $wsdl = 'http://79.98.88.136:8080/prokatbs/ws/aparkrent.1cws?wsdl';
        $client = new \SoapClient($wsdl, [
            'login' => 'exchange',
            'password' => '7S0m0B0d',
            'cache_wsdl' => WSDL_CACHE_MEMORY,
        ]);

        $client->postOrder([
            'data' => $data,
        ]);
    }
}
