<?php

namespace frontend\controllers;

use frontend\forms\ReserveForm;
use yii\helpers\Html;
use yii\web\Controller;

class ReserveController extends Controller
{
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

    public function actionCreate()
    {
        $reserveForm = new ReserveForm();
        if (\Yii::$app->user->isGuest) {
            $reserveForm->scenario = ReserveForm::SCENARIO_NON_LOGGED;
        }
        if ($reserveForm->load(\Yii::$app->request->post()) && $reserveForm->validate() && $reserveForm->createReserve() && $reserveForm->sendMessage()) {
            $reserveForm->soapExport();
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
    }
}