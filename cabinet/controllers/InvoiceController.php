<?php
/**
 * Created at 05.12.2017 17:19
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace cabinet\controllers;


use cabinet\components\CabinetController;
use cabinet\models\Invoice;
use yii\web\NotFoundHttpException;

class InvoiceController extends CabinetController
{
    public function actionIndex($paid = 0)
    {
        return $this->render('index', ['paid' => $paid]);
    }

    public function actionRenderModal($id)
    {
        $invoice = Invoice::findOne($id);
        if (!$invoice) {
            throw new NotFoundHttpException('Счет не найден');
        }
        return  $this->renderPartial('_modal', ['invoice' => $invoice]);
    }
}