<?php
/**
 * Created at 07.10.2017 19:42
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\controllers;

use backend\models\Client;
use backend\models\ClientChange;
use yii\base\Controller;

class ClientChangeController extends Controller
{
    public function actionIndex()
    {
        $changes = ClientChange::find()->distinct('client_id')->all();
        $clientIds = [];
        foreach ($changes as $change) {
            $clientIds[] = $change->client_id;
        }
        $clients = Client::find()->where(['id' => $clientIds])->all();
        return $this->render('index', [
            'clients' => $clients,
        ]);
    }

    public function actionAccept()
    {
        $id = \Yii::$app->request->get('id');
        $change = ClientChange::findOne($id);
        if ($change) {
            $attribute = $change->attribute;
            $change->client->$attribute = $change->new_value;
            if ($change->client->save() && $change->delete()) {
                return json_encode([
                    'status' => 'ok',
                ]);
            }
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }

    public function actionReject()
    {
        $id = \Yii::$app->request->get('id');
        $change = ClientChange::findOne($id);
        if ($change && $change->delete()) {
            return json_encode([
                'status' => 'ok',
            ]);
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }
}