<?php

namespace frontend\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use frontend\models\AdditionalService;
use frontend\models\Client;
use frontend\models\ClientFile;
use frontend\models\Invoice;
use frontend\models\Reserve;
use frontend\models\ReserveAdditionalService;
use frontend\models\SoapReserve;
use frontend\models\Tariff;
use yii\base\Model;

class ReserveForm extends Model
{
    const SCENARIO_NON_LOGGED = 'not_logged';
    const SCENARIO_AJAX = 'ajax';

    public $date_from;
    public $date_to;
    public $date_reserve;

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
            [['date_reserve', 'phone'], 'required', 'on' => 'ajax'],
            [['model_id'], 'required'],
            [['date_from', 'date_to'], 'required', 'when' => function($model){
                return $model->date_reserve ? false : true;
            }],
            [['name', 'email', 'phone', 'delivery_address', 'return_address', 'date_from', 'date_to', 'delivery_time', 'date_reserve'], 'string'],
            [['model_id', 'delivery_type', 'return_type', 'price', 'type'], 'integer'],
            [['addServices', 'reserve', 'files'], 'safe'],
            [['date_from'], 'reserveDateValidator'],
            [['date_reserve'], 'reserveDateRangeValidator'],
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
            'date_reserve' => 'Дата аренды',
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

    public function getDatesWithoutReserveDate($date) {
        $data = explode('до', $date);

        if(count($data) > 1) {
            $from = trim($data[0]);
            $to = trim($data[1]);

            return [
                'from' => $from,
                'to' => $to,
            ];
        }

        return false;
    }

    public function reserveDateRangeValidator($attribute)
    {
        if($dates = $this->getDatesWithoutReserveDate($this->$attribute))
        {
            $dateFrom = \Yii::$app->formatter->asTimestamp($dates['from']);
            $dateTo = \Yii::$app->formatter->asTimestamp($dates['to']);
            if ($dateFrom - $dateTo >= 0) {
                $this->addError($attribute, 'Даты некорректны');
                return false;
            }

            if ($dateFrom < date('now')) {
                $this->addError($attribute, 'Резервы доступны только на будущие дни');
                return false;
            }
        } else {
            $this->addError($attribute, 'Даты некорректны');
            return false;
        }
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function countPrice()
    {
        $formatter = \Yii::$app->formatter;
        $message = '';
        $timeInfo = 0;

        if($this->date_reserve) {
            $dates = $this->getDatesWithoutReserveDate($this->date_reserve);

            $from = $formatter->asTimestamp($dates['from']);
            $to = $formatter->asTimestamp($dates['to']);
        } else {
            if ($this->date_from == 0 || $this->date_to == 0) {
                $message .= '<p>Выберите даты</p>';
                return [
                    'price' => 0,
                    'message' => $message,
                ];
            }

            $from = $formatter->asTimestamp($this->date_from);
            $to = $formatter->asTimestamp($this->date_to);
        }

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
                    /** @var AdditionalService $additionalService */
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

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
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
        $this->reserve->created_at = $formatter->asTimestamp(date('Y-m-d')) + 18000;
        $this->reserve->createInvoice();
        $this->reserve->invoice->price = $this->price;

        if(isset($this->date_reserve)) {
            $dates = $this->getDatesWithoutReserveDate($this->date_reserve);

            $this->reserve->delivery_date = $formatter->asTimestamp($dates['from']);
            $this->reserve->return_date = $formatter->asTimestamp($dates['to']);
        } else {
            $this->reserve->delivery_date = $formatter->asTimestamp($this->date_from);
            $this->reserve->return_date = $formatter->asTimestamp($this->date_to);
        }

        $this->reserve->invoice->save();

        if ($this->reserve->save()) {
            if (($this->delivery_type != '') || ($this->delivery_time != '')) {
                $delivery = new ReserveAdditionalService();
                $delivery->reserve_id = $this->reserve->id;
                $delivery->additional_service_id = $this->delivery_type;
                $delivery->delivery_type = ReserveAdditionalService::DELIVERY_TO_CLIENT;
                $delivery->address = empty($this->delivery_type) ? 'Югорский тракт 1 к.1' : (!empty($this->delivery_address) ? $this->delivery_address : '');
                $delivery->time = $formatter->asTimestamp(!empty($this->delivery_time) ? $this->delivery_time : '09:00');
                $delivery->save();
            }
            foreach ($this->addServices as $key => $value) {
                if ($value) {
                    $service = new ReserveAdditionalService();
                    $service->reserve_id = $this->reserve->id;
                    $service->additional_service_id = $key;
                    $service->save();
                }
            }
            /*if (($this->addServices[10] != 0) || ($this->addServices[11] != 0) || ($this->addServices[12] != 0)) {
                foreach ($this->addServices as $key => $value) {
                    if ($value) {
                        $delivery = new ReserveAdditionalService();
                        $delivery->reserve_id = $this->reserve->id;
                        $delivery->delivery_type = ReserveAdditionalService::DELIVERY_TO_CLIENT;
                        $delivery->address = !empty($this->delivery_address) ? $this->delivery_address : 'Югорский тракт 1 к.1';
                        $delivery->time = $formatter->asTimestamp(!empty($this->delivery_time) ? $this->delivery_time : '09:00');
                        $delivery->reserve_id = $this->reserve->id;
                        $delivery->additional_service_id = $key;
                        $delivery->save();
                    }
                }
            } else if (($this->delivery_type != '') || ($this->delivery_time != '')) {
                $delivery = new ReserveAdditionalService();
                $delivery->reserve_id = $this->reserve->id;
                $delivery->delivery_type = ReserveAdditionalService::DELIVERY_TO_CLIENT;
                $delivery->address = !empty($this->delivery_address) ? $this->delivery_address : 'Югорский тракт 1 к.1';
                $delivery->time = $formatter->asTimestamp(!empty($this->delivery_time) ? $this->delivery_time : '09:00');
                $delivery->save();
            }*/
            $this->files = $this->files == '' ? [] : $this->files;
            foreach ($this->files as $file) {
                $fileToBase = new ClientFile();
                $fileToBase->name = $file['name'];
                $fileToBase->path = $file['path'];
                $fileToBase->client_id = $client->id;
                $fileToBase->save();
            }
            (new SoapReserve)->xmlExport($this->reserve->id, $this->delivery_type);
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
}