<?php

namespace frontend\controllers;

use console\models\parcer\XmlRequestParcer;
use frontend\forms\ReserveForm;
use frontend\models\SoapReserve;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ReserveController extends Controller
{
    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCountPrice()
    {
        $form = new ReserveForm();
        if ($form->load(\Yii::$app->request->post())) {
            $answer = $form->countPrice();
            return json_encode([
                'status' => 'ok',
                'answer' => $answer,
            ]);
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $reserveForm = new ReserveForm();
        if (\Yii::$app->user->isGuest) {
            $reserveForm->scenario = ReserveForm::SCENARIO_NON_LOGGED;
        }
        if ($reserveForm->load(\Yii::$app->request->post()) && $reserveForm->validate() && $reserveForm->createReserve() && $reserveForm->sendMessage()) {
            if (YII_ENV_PROD) {
                (new SoapReserve())->soapExport();
            }
            return json_encode([
                'status' => 'ok',
                'message' => 'Ваша заявка принята и будет обработана в ближайшее время! Номер вашего заказа - ' . $reserveForm->reserve->id,
            ]);
        } else {
            if ($reserveForm->hasErrors()) {
                return json_encode([
                    'status' => 'fail',
                    'message' => Html::errorSummary($reserveForm),
                ]);
            }
        }
    }

    public function actionSoapRequest()
    {
        $xmlString = \Yii::$app->request->post('data');
//        $xmlString = file_get_contents(\Yii::getAlias('@console/data/reserve.xml'));
        $time = microtime(true);

        $parcer = new XmlRequestParcer();
        $parcer->importSoapRequest($xmlString);

        echo microtime(true) - $time;
        $this->sendMessage();
        return true;
    }

    public function sendMessage()
    {
        $emails = ['dmb@goldcarrot.ru'];
        foreach ($emails as $email) {
            \Yii::$app->mailer->compose('test_mail')
                ->setTo($email)
                ->setFrom(['admin@goldcarrot.ru' => 'Gold Carrot'])
                ->setSubject('Резерв с сайта aparkrent.ru')
                ->send();
        }
        return true;
    }

    public function actionValidate()
    {
        $reserveForm = new ReserveForm();
        $reserveForm->scenario = ReserveForm::SCENARIO_AJAX;

        $request = \Yii::$app->getRequest();
        if ($request->isPost && $reserveForm->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($reserveForm);
        }

        return false;
    }
}