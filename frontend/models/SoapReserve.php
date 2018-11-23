<?php

namespace frontend\models;


class SoapReserve extends \common\models\SoapReserve
{
    /**
     * @param null $reserve_id
     * @param $delivery_type_id
     * @throws \yii\base\InvalidConfigException
     */
    public function xmlExport($reserve_id = null, $delivery_type_id)
    {
        $reserve = !empty($reserve_id) ? Reserve::findAll(['id' => $reserve_id]) : [new Reserve()] ;
        $reserveToXml = [
            [
                'tag' => 'AllReserve',
                'elements' => $this->getReserve($reserve, $delivery_type_id)
            ]
        ];

        $request = (new \bupy7\xml\constructor\XmlConstructor())->fromArray($reserveToXml)->toOutput();
        file_put_contents(\Yii::getAlias('@console/data/reserve.xml'), $request . PHP_EOL, FILE_NO_DEFAULT_CONTEXT);
    }

    /**
     * @param $reserve
     * @param $delivery_type_id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function getReserve($reserve, $delivery_type_id)
    {
        $arr = [];
        foreach ($reserve as $key => $item) {
            for ($i = 0; $i < 13; $i++) {
                $option[$i] = 'нет';
            }
            foreach (ReserveAdditionalService::findAll(['reserve_id' => $item->id]) as $value) {
                for ($i = 1; $i < 14; $i++) {
                    if ($value->additional_service_id == $i) {
                        $option[$i-1] = 'да';
                    }
                }
            }
            $arr[$key] = [
                'tag' => 'ReserveCar',
                'attributes' => [
                    'ReserveId' => $item->id,
                    'ModelCode' => $item->model->code,
                    'ModelId' => $item->model->id,
                    'Model' => $item->model->title,
                    'DeliveryDate' => \Yii::$app->formatter->asDatetime($item->delivery_date,'YMMddHHiss'),
                    'ReturnDate' => \Yii::$app->formatter->asDatetime($item->return_date, 'YMMddHHiss'),
                    'Phone' => $item->client->phone,
                    'Price' => $item->invoice->price,
                ],
                'elements' => [
                    [
                        'tag' => 'AdditionalServices',
                        'attributes' => [
                            'Region' => $this->getDeliveryRegion($delivery_type_id),
                            'Address' => $this->getDeliveryAddress($item->id, $delivery_type_id),
                            'Time' => $this->getDeliveryTime($item->id),
                        ],
                    ],
                    [
                        'tag' => 'OptionalEquipment',
                        'attributes' => [
                            'AirportSurgut' => $option[0],
                            'RailwayStation' => $option[1],
                            'DeliveryCity' => $option[2],
                            'Nefteyugansk' => $option[3],
                            'KhantyMansiysk' => $option[4],
                            'Nizhnevartovsk' => $option[5],
                            'Noyabrsk' => $option[6],
                            'NovyUrengoy' => $option[7],
                            'FullCarWash' => $option[8],
                            'VideoRecorder' => $option[9],
                            'Navigator' => $option[10],
                            'BabySeat' => $option[11],
                            'ExpressWash' => $option[12],
                        ],
                    ],
                ],
            ];
        }
        return $arr;
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
}
