<?php

namespace frontend\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use frontend\models\AdditionalService;
use frontend\models\Client;
use frontend\models\ClientFile;
use frontend\models\Invoice;
use frontend\models\Reserve;
use frontend\models\ReserveAdditionalService;
use frontend\models\Tariff;
use yii\base\Model;

class ReserveForm extends Model
{
    const SCENARIO_NON_LOGGED = 'not_logged';

    public $date_from;
    public $date_to;

    public $model_id;

    public $addServices;

    public $delivery_type;
    public $delivery_address;
    public $delivery_time;

    public $return_type;
    public $return_address;

    public $name;
    public $email;
    public $phone;
    public $type;

    public $price;

    public $reserve;
    public $files;

    public function rules()
    {
        return [
            [['phone'], 'required', 'on' => 'not_logged'],
            [['model_id', 'date_from', 'date_to'], 'required'],
            [['name', 'email', 'phone', 'delivery_address', 'return_address', 'date_from', 'date_to', 'delivery_time'], 'string'],
            [['model_id', 'delivery_type', 'return_type', 'price', 'type'], 'integer'],
            [['addServices', 'reserve', 'files'], 'safe'],
            [['date_from'], 'reserveDateValidator'],
            [['delivery_time'], 'date', 'format' => 'php:H:i'],
            [['email'], 'email'],
            [['phone'], PhoneInputValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'ФИО',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'date_from' => 'Дата аренды (с)',
            'date_to' => 'Дата аренды (по)',
            'delivery_time' => 'Время получения автомобиля',
        ];
    }

    public function deliveryTimePrice($attribute)
    {
        if (($this->$attribute >= 20) || ($this->$attribute < 8)) {
            $this->addError($attribute, 'Выдача авто в нерабочее время идет по повышенному тарифу - 500руб');
        }
    }

    public function reserveDateValidator($attribute)
    {
        $dateFrom = \Yii::$app->formatter->asTimestamp($this->$attribute);
        $dateTo = \Yii::$app->formatter->asTimestamp($this->date_to);
        if ($dateFrom - $dateTo >= 0) {
            $this->addError($attribute, 'Даты некорректны');
            return false;
        }
//        if ($dateFrom < time()) {
        if ($dateFrom < date('now')) {
            $this->addError($attribute, 'Резервы доступны только на будущие дни');
            return false;
        }
    }

    public function countPrice()
    {
        $formatter = \Yii::$app->formatter;
        $message = '';
        $timeInfo = 0;
        if ($this->date_from == 0 || $this->date_to == 0) {
            $message .= '<p>Выберите даты</p>';
            return [
                'price' => 0,
                'message' => $message,
            ];
        }
        $from = $formatter->asTimestamp($this->date_from);
        $to = $formatter->asTimestamp($this->date_to);
        if (date('now') > $from) {
            $message .= '<p>Резервирование доступно только на будущие дни</p>';
            return [
                'price' => 0,
                'message' => $message,
            ];
        }
        $minutes = ($to - $from) / 60;
        if ($minutes <= 0) {
            $message .= '<p>Даты некорректны</p>';
            return [
                'price' => 0,
                'message' => $message,
            ];
        }
        $hours = ceil(($to - $from) / 3600);
        $days = (int)(($to - $from) / (24 * 3600));
        $daysForAdditional = ceil($hours/24);
        $price = 0;
        if (($hours < 24) || (ceil($hours % 24)) > 3) {
            $days++;
        } else {
            $price += ceil($hours % 24) * 300;
        }
        $tariff = Tariff::find()->where(['model_id' => $this->model_id])->andWhere(['<=', 'minimal_days', $days])->orderBy('minimal_days DESC')->one();
        if (!$tariff) {
            $message .= '<p>Такой тариф не предусмотрен</p>';
            return [
                'price' => 0,
                'message' => $message,
            ];
        }
        $price += $tariff->price_for_day * $days;
        if ($this->addServices != '') {
            foreach ($this->addServices as $id => $addService) {
                if ($addService == 1) {
                    $additionalService = AdditionalService::findOne($id);
                    if ($additionalService) {
                        if ($additionalService->type == AdditionalService::TYPE_WASH) {
                            $price += $additionalService->price;
                        } else {
                            $price += ($daysForAdditional * $additionalService->price);
                        }
                    }
                }
            }
        }
        if (!empty($this->delivery_time) && (\Yii::$app->formatter->asDatetime($this->delivery_time, 'H') >= 20 || \Yii::$app->formatter->asDatetime($this->delivery_time, 'H') < 8)) {
            $timeInfo = 1;
            $message .= '<p>Выдача автомобиля в нерабочее время +500руб</p>';
            $price += 500;
        }
        if (\Yii::$app->formatter->asDatetime($this->date_to, 'H') >= 20 || \Yii::$app->formatter->asDatetime($this->date_to, 'H') < 8) {
//            if (!$timeInfo) {
//                $message .= '<p>Выдача и забор авто в нерабочее время идет по повышенному тарифу</p>';
//            }
            $price += 0;
        }
        if ($this->delivery_type != '') {
            $delivery = AdditionalService::findOne($this->delivery_type);
            if ($delivery) {
                $price += $delivery->price;
            }
        }
        if ($this->return_type != '') {
            $return = AdditionalService::findOne($this->return_type);
            if ($return) {
                $price += $return->price;
            }
        }
        return [
            'price' => $price,
            'message' => $message,
        ];
    }

    public function createReserve()
    {
        $formatter = \Yii::$app->formatter;
        if ($this->scenario == self::SCENARIO_NON_LOGGED) {
            $client = Client::findOne(['phone' => $this->phone]);
            if ($client == null) {
                $client = new Client();
                $client->type = $this->type;
                if ($client->type == Client::TYPE_INDIVIDUAL) {
                    $client->name = $this->name;
                } else {
                    $client->company_name = $this->name;
                }
                $client->phone = $this->phone;
                $client->email = $this->email;
                $client->save();
            }
        } else {
            $client = \Yii::$app->user->identity->client;
        }
        $this->reserve = new Reserve();
        $this->reserve->client_id = $client->id;
        $this->reserve->model_id = $this->model_id;
        $this->reserve->delivery_date = $formatter->asTimestamp($this->date_from);
        $this->reserve->return_date = $formatter->asTimestamp($this->date_to);
        $this->reserve->created_at = $formatter->asTimestamp(date('Y-m-d')) + 18000;
        $this->reserve->createInvoice();
        $this->reserve->invoice->price = $this->price;
        $this->reserve->invoice->save();

        if ($this->reserve->save()) {
            if ($this->delivery_type != '') {
                $delivery = new ReserveAdditionalService();
                $delivery->reserve_id = $this->reserve->id;
                $delivery->additional_service_id = $this->delivery_type;
                $delivery->delivery_type = ReserveAdditionalService::DELIVERY_TO_CLIENT;
                $delivery->address = $this->delivery_address;
                $delivery->time = $formatter->asTimestamp($this->delivery_time);
                $delivery->save();
            } else if ($this->delivery_time != '') {
                $delivery = new ReserveAdditionalService();
                $delivery->reserve_id = $this->reserve->id;
                $delivery->delivery_type = ReserveAdditionalService::DELIVERY_TO_CLIENT;
                $delivery->address = 'Югорский тракт 1 к.1';
                $delivery->time = $formatter->asTimestamp($this->delivery_time);
                $delivery->save();
            }
            if ($this->return_type != '') {
                $return = new ReserveAdditionalService();
                $return->reserve_id = $this->reserve->id;
                $return->additional_service_id = $this->return_type;
                $return->delivery_type = ReserveAdditionalService::DELIVERY_FROM_CLIENT;
                $return->address = $this->return_address;
                $return->time = $formatter->asTimestamp($this->delivery_time);
                $return->save();
            }
            foreach ($this->addServices as $key => $value) {
                if ($value) {
                    $service = new ReserveAdditionalService();
                    $service->reserve_id = $this->reserve->id;
                    $service->additional_service_id = $key;
                    $service->save();
                }
            }
            $this->files = $this->files == '' ? [] : $this->files;
            foreach ($this->files as $file) {
                $fileToBase = new ClientFile();
                $fileToBase->name = $file['name'];
                $fileToBase->path = $file['path'];
                $fileToBase->client_id = $client->id;
                $fileToBase->save();
            }
            $this->actionExport();
            return true;
        }
        return false;
    }

    public function sendMessage()
    {
        $emails = ['info@aparkrent.ru', 'admin@goldcarrot.ru'];
        foreach ($emails as $email) {
            \Yii::$app->mailer->compose('reserve_mail', [
                'reserve' => $this->reserve,
            ])
                ->setTo($email)
                ->setFrom(['admin@goldcarrot.ru' => 'Gold Carrot'])
                ->setSubject('Резерв с сайта aparkrent.ru')
                ->send();
        }
        return true;
    }

    public function actionExport()
    {
        $reserve = Reserve::find()->where(['created_at' => \Yii::$app->formatter->asTimestamp(date("Y-m-d")) + 18000])->all();
        $reserveToXml = [
            [
                'tag' => 'AllReserve',
                'elements' => $this->getReserve($reserve)
            ]
        ];

        $request = (new \bupy7\xml\constructor\XmlConstructor())->fromArray($reserveToXml)->toOutput();
        file_put_contents(\Yii::getAlias('@console/data/reserve.xml'), $request . PHP_EOL, FILE_NO_DEFAULT_CONTEXT);
//        $this->soapExport();
    }

    private function getReserve($reserve)
    {
        $arr = [];
        foreach ($reserve as $key => $item) {
            $option = ['нет', 'нет', 'нет'];
            foreach (ReserveAdditionalService::findAll(['reserve_id' => $item->id]) as $value) {
                switch ($value->additional_service_id) {
                    case 10: $option[0] = 'да';
                        break;
                    case 11: $option[1] = 'да';
                        break;
                    case 12: $option[2] = 'да';
                        break;
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
                            'VideoRecorder' => $option[0],
                            'Navigator' => $option[1],
                            'BabySeat' => $option[2],
                        ],
                    ],
                ],
            ];
        }
        return $arr;
    }

    private function getDeliveryTime($id){
        $item = ReserveAdditionalService::findOne(['reserve_id' => $id]);
        return !empty($item->time) ? \Yii::$app->formatter->asDatetime($item->time, 'HH:i') : '09:00';
    }

    private function getDeliveryAddress($id){
        $item = ReserveAdditionalService::findOne(['reserve_id' => $id]);
        return !empty($item->address) ? $item->address : 'Югорский тракт 1 к.1';
    }

    private function soapExport()
    {
        $wsdl = 'http://79.98.88.136:8080/prokatbs/ws/aparkrent.1cws?wsdl';

        $client = new \SoapClient($wsdl, [
            'login' => 'exchange',
            'password' => '7S0m0B0d',
            'cache_wsdl' => WSDL_CACHE_MEMORY,
        ]);

        $client->postOrder([
            'data' => file_get_contents(\Yii::getAlias('@console/data/reserve.xml')),
        ]);
    }
}