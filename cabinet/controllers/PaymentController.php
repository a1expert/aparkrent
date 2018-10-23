<?php
/**
 * Created at 14.11.2017 14:42
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace cabinet\controllers;

use cabinet\components\CabinetController;
use cabinet\models\Client;
use cabinet\models\Invoice;
use cabinet\payment\Sberbank;
use ErrorException;
use yii\web\Response;

class PaymentController extends CabinetController
{
    public function actionSuccess()
    {
        return $this->render('success');
    }
    
    public function actionFail($id)
    {
        return $this->render('fail', ['id' => $id]);
    }

    /**
     * Успешная оплата
     * @param $id
     * @return int|\yii\web\Response
     */
    public function actionAviso($id)
    {
        if (Sberbank::processPayment($id)) {
            return $this->redirect(['/payment/success']);
        }
        return $this->redirect(['/payment/fail', 'id' => $id]);
    }

    public function actionAddBonuses($client_id, $invoice_id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $invoice = Invoice::findOne($invoice_id);
        if (!$invoice || $invoice->isFine() || $invoice->price <= 0 || $invoice->paid_at != null) {
            return [
                'status' => 'fail',
                'message' => 'К этому счету невозможно применить бонусы',
            ];
        }
        $currentBonuses = $invoice->bonuses;
        $bonuses = \Yii::$app->request->post('bonuses');
        $needBonuses = $bonuses - $currentBonuses;
        $client = Client::findOne($client_id);
        if (!$client || $bonuses < 0 || $client->bonus_balance < $needBonuses) {
            return [
                'status' => 'fail',
                'message' => 'Невозможно снять бонусы',
            ];
        }
        $invoice->bonuses += $needBonuses;
        $invoice->save(false);
        $client->bonus_balance -= $needBonuses;
        $client->save(false);
        return [
            'status' => 'success',
            'price' => number_format($invoice->getPriceForPayment(), 2, '.', ' ') . ' ₽',
            'bonusesBalance' => number_format($client->bonus_balance, 2, '.', ' '),
        ];
    }

    public function actionSendToSberbank($invoice_id)
    {
        $invoice = Invoice::findOne($invoice_id);
        if ($invoice->getPriceForPayment() == 0 && $invoice->price != null) {
            $invoice->setPayedFlag();
            return $this->redirect(['/payment/success']);
        }
        $sberbankLink = Sberbank::prepareOrder($invoice_id);
        if ($sberbankLink == null) {
            throw new ErrorException('Заказ не может быть обработан банком');
        }
        return $this->redirect($sberbankLink);
    }
}