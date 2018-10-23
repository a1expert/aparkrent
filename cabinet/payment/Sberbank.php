<?php
/**
 * Created at 14.1.2017 14:41
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace cabinet\payment;

use cabinet\models\Invoice;
use cabinet\models\Reserve;
use yii\helpers\Url;

class Sberbank
{
    const USER_NAME = 'aparkrent-api';
    const PASSWORD = YII_DEBUG ? 'aparkrent' : '1asD24dFd2!';

    const REGISTER = YII_DEBUG ? 'https://3dsec.sberbank.ru/payment/rest/register.do' : 'https://securepayments.sberbank.ru/payment/rest/register.do';
    const GET_INFO = YII_DEBUG ? 'https://3dsec.sberbank.ru/payment/rest/getOrderStatus.do' : 'https://securepayments.sberbank.ru/payment/rest/getOrderStatus.do';

    public static function prepareOrder($id)
    {
        $invoice = Invoice::findOne($id);
        if (($invoice !== null) && ($invoice->paid_at == null)) {

            $form['userName'] = self::USER_NAME;
            $form['password'] = self::PASSWORD;
            $form['orderNumber'] = $invoice->id . '-' . (int)$invoice->counter;
            $form['description'] = $invoice->getPaymentText();
            $form['amount'] = (int)($invoice->getPriceForPayment() * 100);
            $form['returnUrl'] = Url::to(['/payment/aviso', 'id' => $invoice->id], true);

            if ($curl = curl_init()) {
                curl_setopt($curl, CURLOPT_URL, self::REGISTER);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($form));
                $return = json_decode(curl_exec($curl), true);
                curl_close($curl);
                if (isset($return['orderId'], $return['formUrl'])) {
                    $invoice->counter += 1;
                    $invoice->sberbank_id = $return['orderId'];
                    $invoice->save(false);
                    return $return['formUrl'];
                }
            }
        }
        return null;
    }
    public static function getOrderInfo($id)
    {
        $invoice = Invoice::findOne($id);
        if (($invoice !== null) && ($invoice->sberbank_id != null) && ($invoice->paid_at == null)) {

            $form['userName'] = self::USER_NAME;
            $form['password'] = self::PASSWORD;
            $form['orderId'] = $invoice->sberbank_id;
            if ($curl = curl_init()) {
                curl_setopt($curl, CURLOPT_URL, self::GET_INFO);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($form));
                $data = curl_exec($curl);
                $return = json_decode($data, true);
                curl_close($curl);
                return $return;
            }
        }
        return null;
    }

    public static function processPayment($id)
    {
        $info = self::getOrderInfo($id);
        if (($info !== null)) {
            \Yii::info('Проверка оплаты', 'payments');
            $invoiceId = explode('-', $info['OrderNumber'])[0];
            $invoice = Invoice::findOne(['id' => $invoiceId]);
            if (($invoice !== null)) {
                if ($invoice->paid_at != null) {
                    \Yii::info('Счет уже оплачен', 'payments');
                    return true;
                }
                \Yii::info('Резерв существует', 'payments');
                if (isset($info['OrderStatus']) && ($info['OrderStatus'] == 2)) {
                    $invoice->setPayedFlag();
                    return true;
                } else {
                    \Yii::info('OrderStatus wrong', 'payments');
                    return false;
                }
            }
            \Yii::info('Резерв отсутствует или уже оплачен', 'payments');
            return false;
        }
        \Yii::info('Заказ не зарегистрирован', 'payments');
        return false;
    }
}