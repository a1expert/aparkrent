<?php
/**
 * Created by 24.11.2018 19:47
 * @author dmitrybormisov <dmb@goldcarrot.ru>
 */

namespace common\models;

use yii\base\Model;

class SoapClient extends Model
{
    /**
     * @param null $client_id
     * @throws \yii\base\InvalidConfigException
     */
    public function xmlExport($client_id = null)
    {
        $client = !empty($client_id) ? Client::findAll(['id' => $client_id]) : [new Client()] ;
        $clientToXml = [
            [
                'tag' => 'AllClients',
                'elements' => $this->getClient($client)
            ]
        ];

        $request = (new \bupy7\xml\constructor\XmlConstructor())->fromArray($clientToXml)->toOutput();
        file_put_contents(\Yii::getAlias('@console/data/client.xml'), $request . PHP_EOL, FILE_NO_DEFAULT_CONTEXT);
    }

    /**
     * @param $client
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function getClient($client)
    {
        $arr = [];
        foreach ($client as $key => $item) {
            $arr[$key] = [
                'tag' => 'Client',
                'attributes' => [
                    'Id' => $item->id,
                    'Type' => $this->isType($item->type),
                ],
                'elements' => [
                    [
                        'tag' => 'GeneralInformation',
                        'attributes' => [
                            'Surname' => $this->isEmpty($item->surname),
                            'Name' => $this->isEmpty($item->name),
                            'Patronymic' => $this->isEmpty($item->patronymic),
                            'Email' => $this->isEmpty($item->email),
                            'Phone' => $item->phone,
                        ],
                    ],
                    [
                        'tag' => 'AdditionalInformation',
                        'attributes' => [
                            'Birthday' => $this->isEmpty($item->birthday,'date'),
                            'AdditionalPhone' => $this->isEmpty($item->additional_phone),
                            'RelativePhone' => $this->isEmpty($item->relative_phone),
                            'BonusBalance' => $this->isEmpty($item->bonus_balance),
                        ],
                        'elements' => [
                            [
                                'tag' => 'PassportInformation',
                                'attributes' => [
                                    'PassportSeries' => $this->isEmpty($item->passport_series),
                                    'PassportNumber' => $this->isEmpty($item->passport_number),
                                    'PassportDateIssue' => $this->isEmpty($item->passport_date_issue,'date'),
                                    'PassportPlaceIssue' => $this->isEmpty($item->passport_place_issue),
                                    'RegistrationPlace' => $this->isEmpty($item->registration_place),
                                    'ResidencePlace' => $this->isEmpty($item->residence_place),
                                ],
                            ],
                            [
                                'tag' => 'DriveLicenseInformation',
                                'attributes' => [
                                    'DriveLicenseSeries' => $this->isEmpty($item->drive_license_series),
                                    'DriveLicenseNumber' => $this->isEmpty($item->drive_license_number),
                                    'DriveLicenseIssueDate' => $this->isEmpty($item->drive_license_issue_date,'date'),
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }
        return $arr;
    }

    /**
     * @param $item
     * @return string
     */
    private function isType($item) {
        return $item == Client::TYPE_INDIVIDUAL ? 'individual' : 'legal';
    }

    /**
     * @param $item
     * @param null $type
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    private function isEmpty($item, $type = null) {
        if ($type == 'date') {
            return !empty($item) ? \Yii::$app->formatter->asDatetime($item,'YMMddHHiss') : '';
        }
        return !empty($item) ? $item : '';
    }

    public function soapExport()
    {
        $data = file_get_contents(\Yii::getAlias('@console/data/client.xml'));
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