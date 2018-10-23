<?php

namespace backend\controllers;

use backend\models\Defect;
use Yii;
use backend\models\Car;
use backend\models\search\CarSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CarController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Car();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteDefect($car_id, $defect_id)
    {
        $defect = Defect::find()->where(['car_id' => $car_id, 'id' => $defect_id])->one();
        if ($defect && $defect->delete()) {
            return $this->redirect(['view', 'id' => $car_id]);
        }
    }

    public function actionAddDefect($car_id)
    {
        $defect = new Defect();
        if ($defect->load(Yii::$app->request->post()) && $defect->save()) {
            return $this->redirect(['view', 'id' => $car_id]);
        } else {
            $defect->car_id = $car_id;
            return json_encode([
                'status' => 'ok',
                'content' => $this->renderAjax('defects/_form', [
                    'defect' => $defect,
                ]),
            ]);
        }
    }
}
