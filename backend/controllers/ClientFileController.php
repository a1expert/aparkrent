<?php
/**
 * Created at 07.10.2017 15:50
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\controllers;

use backend\models\Client;
use backend\models\ClientFile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ClientFileController extends Controller
{
    public function behaviors()
    {
        return [
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

    public function actionCreate($id = null)
    {
        $this->viewPath = Yii::getAlias('@backend/views/client');
        $file = new ClientFile();
        if ($file->load(Yii::$app->request->post()) && $file->save()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
                'content' => $this->renderAjax('files/_item', [
                    'model' => $file->client,
                    'file' => $file,
                ]),
            ]);
        } else {
            $client = Client::findOne($id);
            if (!$client) {
                return json_encode([
                    'status' => 'fail',
                    'message' => 'Резерв не найден',
                ]);
            }
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('files/_form', [
                    'model' => $client,
                    'file' => $file,
                ]),
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $this->viewPath = Yii::getAlias('@backend/views/client');
        $file =  ClientFile::findOne($id);
        if ($file->load(Yii::$app->request->post()) && $file->save()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
                'content' => $this->renderAjax('files/_item', [
                    'model' => $file->client,
                    'file' => $file,
                ]),
            ]);
        } else {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('files/_form', [
                    'model' => $file->client,
                    'file' => $file,
                ]),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $file = ClientFile::findOne($id);
        if ($file->delete()) {
            return json_encode([
                'status' => 'ok',
            ]);
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }
}