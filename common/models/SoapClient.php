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
     * @param $client_id
     * @throws \yii\base\InvalidConfigException
     */
    public function xmlExport($client_id)
    {
        $client = Client::findOne(['id' => $client_id]);
        $clientToXml = [
            [
                'tag' => 'AllClients',
                'elements' => [
                    [
                        'tag' => 'Client',
                        'attributes' => [
                            'Id' => $client->id,
                            'Type' => $this->getType($client->type),
                            'Status' => $this->getStatus($client->status),
                            'Source' => $this->getSource($client->source),
                        ],
                        'elements' => [
                            [
                                'tag' => 'GeneralInformation',
                                'attributes' => [
                                    'Surname' => $this->isEmpty($client->surname),
                                    'Name' => $this->isEmpty($client->name),
                                    'Patronymic' => $this->isEmpty($client->patronymic),
                                    'Email' => $this->isEmpty($client->email),
                                    'Phone' => $client->phone,
                                ],
                            ],
                            [
                                'tag' => 'AdditionalInformation',
                                'attributes' => [
                                    'Birthday' => $this->isEmpty($client->birthday,'date'),
                                    'AdditionalPhone' => $this->isEmpty($client->additional_phone),
                                    'RelativePhone' => $this->isEmpty($client->relative_phone),
                                    'BonusBalance' => $this->isEmpty($client->bonus_balance),
                                ],
                                'elements' => [
                                    [
                                        'tag' => 'PassportInformation',
                                        'attributes' => [
                                            'PassportSeries' => $this->isEmpty($client->passport_series),
                                            'PassportNumber' => $this->isEmpty($client->passport_number),
                                            'PassportDateIssue' => $this->isEmpty($client->passport_date_issue,'date'),
                                            'PassportPlaceIssue' => $this->isEmpty($client->passport_place_issue),
                                            'RegistrationPlace' => $this->isEmpty($client->registration_place),
                                            'ResidencePlace' => $this->isEmpty($client->residence_place),
                                        ],
                                    ],
                                    [
                                        'tag' => 'DriveLicenseInformation',
                                        'attributes' => [
                                            'DriveLicenseSeries' => $this->isEmpty($client->drive_license_series),
                                            'DriveLicenseNumber' => $this->isEmpty($client->drive_license_number),
                                            'DriveLicenseIssueDate' => $this->isEmpty($client->drive_license_issue_date,'date'),
                                        ],
                                    ],
                                ],
                            ],
                            $client->type == Client::TYPE_LEGAL ? $this->getCompanyInformation($client) : '',
                        ],
                    ],
                ],
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
    private function getCompanyInformation($client) {
        return [
            'tag' => 'CompanyInformation',
            'attributes' => [
                'CompanyName' => $this->isEmpty($client->company_name),
                'CompanyResidence' => $this->isEmpty($client->company_residence),
                'CompanyPhone' => $this->isEmpty($client->company_phone),
                'CompanyEmail' => $this->isEmpty($client->company_email),
            ],
            'elements' => [
                [
                    'tag' => 'BillingInformation',
                    'attributes' => [
                        'INN' => $this->isEmpty($client->inn),
                        'KPP' => $this->isEmpty($client->kpp),
                        'OGRN' => $this->isEmpty($client->ogrn),
                        'CheckingAccount' => $this->isEmpty($client->passport_place_issue),
                        'BIK' => $this->isEmpty($client->bik),
                        'Bank' => $this->isEmpty($client->bank),
                        'CorrespondentAccount' => $this->isEmpty($client->account_number),
                    ],
                ],
                [
                    'tag' => 'OtherInformation',
                    'attributes' => [
                        'PostInCompany' => $this->isEmpty($client->post_in_company),
                        'FioForPaper' => $this->isEmpty($client->fio_for_paper),
                        'NameForSignature' => $this->isEmpty($client->name_for_signature),
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $status
     * @return string
     */
    private function getStatus($status) {
        switch ($status) {
            case Client::STATUS_NOT_VERIFIED: $status = 'Не подтвержденный' ;
                break;
            case Client::STATUS_VERIFIED: $status = 'Подтвержденный' ;
                break;
            case Client::STATUS_DELETED: $status = 'Удален' ;
                break;
            case Client::STATUS_DENIED: $status = 'Отказано' ;
                break;
        }
        return $status;
    }

    /**
     * @param $source
     * @return string
     */
    private function getSource($source) {
        return $source == Client::SOURCE_SITE ? 'С сайта' : 'Добавил менеджер' ;
    }

    /**
     * @param $type
     * @return string
     */
    private function getType($type) {
        return $type == Client::TYPE_INDIVIDUAL ? 'Физ. лицо' : 'Юр. лицо';
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