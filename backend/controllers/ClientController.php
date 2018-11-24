<?php

namespace backend\controllers;

use backend\models\Client;
use backend\models\search\ClientSearch;
use common\models\SoapClient;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null && $model->status != Client::STATUS_DELETED) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param null $type
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate($type = null)
    {
        $model = new Client();
        if ($type != null) {
            $model->type = $type;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            (new SoapClient())->xmlExport($model->id);
            /*if (YII_ENV_PROD) {
                (new SoapClient())->soapExport();
            }*/
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            (new SoapClient())->xmlExport($id);
            /*if (YII_ENV_PROD) {
                (new SoapClient())->soapExport();
            }*/
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Client::STATUS_DELETED;
        $model->save(false);
        return $this->redirect(['index', 'ClientSearch[type]' => $model->type]);
    }

    public function actionGetSpecialFields($type, $id)
    {
        $model = Client::findOne($id);
        $form = new ActiveForm();
        if (!$model) {
            $model = new Client();
        }
        if ($type == Client::TYPE_INDIVIDUAL) {
            return json_encode(['status' => 'ok',
                'content' => $this->renderPartial('_individual', [
                    'model' => $model,
                    'form' => $form,
                ]),
            ]);
        }
        if ($type == Client::TYPE_LEGAL) {
            return json_encode(['status' => 'ok',
                'content' => $this->renderPartial('_legal', [
                    'model' => $model,
                    'form' => $form,
                ]),
            ]);
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }

    public function actionStatusChange()
    {
        $id = Yii::$app->request->post('id');
        $client = Client::findOne($id);
        if (!$client) {
            return json_encode([
                'status' => 'fail',
                'message' => 'Клиент не найден',
            ]);
        } else {
            $status = Yii::$app->request->post('status');
            $client->status = $status;
            if ($client->save()) {
                return json_encode([
                    'status' => 'ok',
                ]);
            } else {
                return json_encode([
                    'status' => 'fail',
                    'message' => 'Ошибка при сохранении',
                ]);
            }
        }
    }

    public function actionGetFileTable($id)
    {
        $client = Client::findOne($id);
        if (!$client) {
            return json_encode([
                'status' => 'fail',
                'message' => 'Клиент не найден',
            ]);
        } else {
            return json_encode([
                'status' => 'ok',
                'content' => $this->renderPartial('files/_list', ['model' => $client]),
            ]);
        }
    }

    public function actionSendNewPassword($client_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $client = Client::findOne($client_id);
        if ($client && $client->status == Client::STATUS_VERIFIED && $user = $client->getUser()) {
            if ($user->resendPassword()) {
                return [
                    'status' => 'success',
                ];
            }
        }
        return [
            'status' => 'fail',
            'message' => 'Ошибка при отправки СМС',
        ];
    }
}
