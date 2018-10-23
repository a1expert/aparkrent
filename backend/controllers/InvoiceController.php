<?php
/**
 * Created at 17.11.2017 18:16
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\controllers;


use backend\models\Invoice;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class InvoiceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSetPay($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $invoice = Invoice::findOne($id);
        if (!$invoice || $invoice->price == 0 || $invoice->paid_at != null) {
            $message = $invoice == null ? 'Счет не найден!' : ($invoice->price == 0 ? 'Цена не установлена!' : 'Счет уже оплачен');
            return [
                'status' => 'fail',
                'message' => $message,
            ];
        }
        if ($invoice->setPayedFlag()) {
            return [
                'status' => 'success',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Серверная ошибка, попробуйте позже',
        ];
    }

    public function actionReturnPay($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $invoice = Invoice::findOne($id);
        if (!$invoice || $invoice->paid_at == null) {
            $message = $invoice == null ? 'Счет не найден!' : 'Счет не оплачен';
            return [
                'status' => 'fail',
                'message' => $message,
            ];
        }
        if ($invoice->unsetPayedFlag()) {
            return [
                'status' => 'success',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Серверная ошибка, попробуйте позже',
        ];
    }
}