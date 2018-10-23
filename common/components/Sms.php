<?php

namespace common\components;

use yii\base\Component;

/**
 * components => [
 *  ...
 *      'sms' => [
 *          'class' => 'common\components\Sms',
 *          'app_id' => 'BB7D3637-F87A-AE2C-0C2C-0E789F498E0D',
 *      ],
 *  ...
 * ]
 *
 * Class Sms
 * @package common\components
 */
class Sms extends Component
{
    /**
     * Ключ приложения на sms.ru
     * @var string
     */
    public $app_id;
    public $sender = 'Avtopark';

    /**
     * @var \Zelenin\SmsRu\Api
     */
    private $client;

    /**
     * Описание кодов ошибки которые показываются клиенту
     * @var array
     */
    protected $availableDescriptions = [
        '100' => 'Сообщение принято к отправке. На следующих строчках вы найдете идентификаторы отправленных сообщений в том же порядке, в котором вы указали номера, на которых совершалась отправка.',
        '200' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже..',
        '201' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '202' => 'Неправильно указан получатель.',
        '203' => 'Нет текста сообщения.',
        '204' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '205' => 'Сообщение слишком длинное (превышает 8 СМС).',
        '206' => 'Будет превышен или уже превышен дневной лимит на отправку сообщений.',
        '207' => 'На этот номер нельзя отправлять сообщения',
        '208' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '209' => 'На этот номер нельзя отправлять сообщения',
        '210' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '211' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '212' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '220' => 'Сервис временно недоступен, попробуйте чуть позже.',
        '230' => 'Сообщение не принято к отправке, так как на один номер в день нельзя отправлять более 60 сообщений.',
        '300' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '301' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
        '302' => 'Произошла серверная ошибка при отправке смс. Попробуйте позже.',
    ];

    /**
     * Получаем клиент
     * @return \Zelenin\SmsRu\Api
     */
    private function getClient()
    {
        return new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($this->app_id));
    }

    public function init()
    {
        $this->client = $this->getClient();
        parent::init();
    }

    /**
     * Отправляем сообщение
     * @param $phone string
     * @param $text string
     * @return bool
     */
    public function send($phone, $text)
    {
        $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $text);
        $sms->from = $this->sender;
        $sms->test = YII_ENV_DEV;
        $smsResponse = $this->client->smsSend($sms);
        if ($smsResponse->code == 100) {
            \Yii::info(['Отправка смс', $smsResponse->code . ': ' . $smsResponse->getDescription() . PHP_EOL . $text], 'sms');
            return true;
        }
        \Yii::info(['Ошибка при отправке смс', $smsResponse->code . ': ' . $smsResponse->getDescription()], 'sms');
        \Yii::$app->session->setFlash('smsError', $this->getResponseDescription($smsResponse->code));
        return false;
    }

    /**
     * @param $code
     * @return mixed|string
     */
    public function getResponseDescription($code)
    {
        return isset($this->availableDescriptions[$code]) ? $this->availableDescriptions[$code] : 'Ошибка при отправке смс!';
    }
}