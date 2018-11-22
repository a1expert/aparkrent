<?php

namespace backend\models;

use yii\base\Model;

class SoapReserve extends Model
{
    /**
     * @param $reserve_id
     * @throws \yii\base\InvalidConfigException
     */
    public function actionXmlExport($reserve_id = null)
    {
        $reserve = !empty($reserve_id) ? Reserve::findAll(['id' => $reserve_id]) : [new Reserve()] ;
        $reserveToXml = [
            [
                'tag' => 'AllReserve',
                'elements' => $this->getReserve($reserve)
            ]
        ];

        $request = (new \bupy7\xml\constructor\XmlConstructor())->fromArray($reserveToXml)->toOutput();
        file_put_contents(\Yii::getAlias('@console/data/reserve.xml'), $request . PHP_EOL, FILE_NO_DEFAULT_CONTEXT);
    }

    /**
     * @param $reserve
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function getReserve($reserve)
    {
        $arr = [];
        foreach ($reserve as $key => $item) {
            $option = ['нет','нет','нет','нет','нет','нет','нет','нет','нет','нет','нет','нет','нет'];
            foreach (ReserveAdditionalService::findAll(['reserve_id' => $item->id]) as $value) {
                for ($i = 1; $i < 14; $i++) {
                    $option[$i-1] = $value->additional_service_id == $i ? 'да' : 'нет' ;
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
                            'Address' => $this->getDeliveryAddress($item->id),
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
     * @return string
     */
    private function getDeliveryAddress($id) {
        $item = ReserveAdditionalService::findOne(['reserve_id' => $id]);
        return !empty($item->address) ? $item->address : 'Югорский тракт 1 к.1';
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
