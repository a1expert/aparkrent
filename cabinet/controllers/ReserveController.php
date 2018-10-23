<?php
/**
 * Created at 05.12.2017 16:39
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace cabinet\controllers;


use cabinet\components\CabinetController;
use cabinet\models\Reserve;
use Yii;
use yii\web\NotFoundHttpException;

class ReserveController extends CabinetController
{
    public function actionIndex($status = Reserve::LEAD_STATUS_OPEN)
    {
        return $this->render('index', ['status' => $status]);
    }

    public function actionDocuments($id)
    {
        if (!($reserve = Reserve::findOne($id)) || $reserve->client_id != Yii::$app->user->identity->client->id) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $this->render('documents', ['reserve' => $reserve]);
    }
}