<?php

namespace backend\controllers;

use backend\forms\FineForm;
use backend\models\Reserve;
use Yii;
use backend\models\Fine;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * FineController implements the CRUD actions for Fine model.
 */
class FineController extends Controller
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

    public function actionCreate($id = null)
    {
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $fineForm = new FineForm();
        if ($fineForm->load(Yii::$app->request->post()) && $fineForm->saveFine()) {
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
                'content' => $this->renderAjax('fines/_form', [
                    'model' => $reserve,
                    'fineForm' => $fineForm,
                ]),
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $fine =  Fine::findOne($id);
        $fineForm = new FineForm();
        $fineForm->fine = $fine;
        $fineForm->setFromFine($fine);
        if ($fineForm->load(Yii::$app->request->post()) && $fineForm->saveFine()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
            ]);
        } else {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('fines/_form', [
                    'model' => $fine->reserve,
                    'fineForm' => $fineForm,
                ]),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $fine = Fine::findOne($id);
        if ($fine->delete()) {
            return json_encode([
                'status' => 'ok',
            ]);
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }
}
