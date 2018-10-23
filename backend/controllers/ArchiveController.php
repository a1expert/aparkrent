<?php
/**
 * Created at 02.11.2017 21:06
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\controllers;


use backend\models\Reserve;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ArchiveController extends Controller
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

    public function actionLead()
    {
        $query = Reserve::find()->where(['lead_status' => Reserve::LEAD_STATUS_CLOSE])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('lead', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReserve()
    {
        $query = Reserve::find()->where(['status' => Reserve::STATUS_REJECTED])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('reserve', [
            'dataProvider' => $dataProvider,
        ]);
    }
}