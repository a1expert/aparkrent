<?php
namespace cabinet\controllers;

use cabinet\components\CabinetController;
use cabinet\models\Invoice;
use yii\base\ErrorException;

class SiteController extends CabinetController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPayment($id)
    {
        $invoice = Invoice::findOne($id);
        if ($invoice) {
            if ($invoice->isReserve()) {
                $reserve = $invoice->reserve;
                return $this->render('payment', [
                    'reserve' => $reserve,
                ]);
            }
            if ($invoice->isFine() || $invoice->isChild()) {
                return $this->redirect(['/payment/send-to-sberbank', 'invoice_id' => $id]);
            }
        }
        throw new ErrorException('Ошибка при обработке заказа');
    }
}
