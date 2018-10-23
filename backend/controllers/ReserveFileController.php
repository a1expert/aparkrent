<?php

namespace backend\controllers;

use backend\models\Reserve;
use backend\models\ReserveFile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ReserveFileController extends Controller
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
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $file = new ReserveFile();
        if ($file->load(Yii::$app->request->post()) && $file->save()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
            ]);
        } else {
            $reserve = Reserve::findOne($id);
            if (!$reserve) {
                return json_encode([
                    'status' => 'fail',
                    'message' => 'Резерв не найден',
                ]);
            }
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('files/_form', [
                    'model' => $reserve,
                    'file' => $file,
                ]),
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $file =  ReserveFile::findOne($id);
        if ($file->load(Yii::$app->request->post()) && $file->save()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
            ]);
        } else {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('files/_form', [
                    'model' => $file->reserve,
                    'file' => $file,
                ]),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $file = ReserveFile::findOne($id);
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