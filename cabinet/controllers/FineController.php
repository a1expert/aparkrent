<?php

namespace cabinet\controllers;

use cabinet\components\CabinetController;
use Yii;

/**
 * Created at 05.12.2017 17:22
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

class FineController extends CabinetController
{
    public function actionIndex($paid = 0)
    {
        $client = Yii::$app->user->identity->client;
        $fines = [];
        foreach ($client->fines as $fine) {
            if ($paid == ($fine->invoice->paid_at != null)) {
                $fines[] = $fine;
            }
        }
        return $this->render('index', [
            'fines' => $fines,
            'paid' => $paid,
        ]);
    }
}