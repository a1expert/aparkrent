<?php

namespace backend\controllers;

use backend\forms\AdditionalReserveForm;
use backend\forms\ReserveForm;
use backend\models\AdditionalService;
use backend\models\Client;
use backend\models\Reserve;
use backend\models\ReserveAdditionalService;
use backend\models\search\ReserveSearch;
use backend\models\SoapReserve;
use backend\services\CountReservePriceService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReserveController implements the CRUD actions for Reserve model.
 */
class ReserveController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReserveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Reserve
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Reserve::findOne($id)) !== null && $model->status != Reserve::STATUS_DELETED) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new ReserveForm();
        $model->reserve = new Reserve();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            (new SoapReserve())->actionXmlExport($model->reserve->id);
//            $exportSoapRequest->soapExport();
            return $this->redirect(['view', 'id' => $model->reserve->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = new ReserveForm();
        $model->setReserve($this->findModel($id));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            (new SoapReserve())->actionXmlExport($id);
//            $exportSoapRequest->soapExport();
            return $this->redirect(['view', 'id' => $model->reserve->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Reserve::STATUS_DELETED;
        $model->save();
        if ($model->lead_status != null) {
            return $this->redirect(['lead']);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddService($id)
    {
        $service = new AdditionalReserveForm();
        if ($service->load(Yii::$app->request->post()) && $service->save()) {
            (new SoapReserve())->actionXmlExport($id);
//            $exportSoapRequest->soapExport();
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
                'content' => $this->renderAjax('services/_form', [
                    'model' => $reserve,
                    'service' => $service,
                ]),
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteService($id)
    {
        $service = ReserveAdditionalService::findOne($id);
        $reserve_id = $service->reserve_id;
        if ($service && $service->delete()) {
            (new SoapReserve())->actionXmlExport($reserve_id);
//            $exportSoapRequest->soapExport();
            return json_encode([
                'status' => 'ok',
            ]);
        }
        return json_encode([
            'status' => 'fail',
        ]);
    }

    public function actionGetListService()
    {
        $type = Yii::$app->request->post('type');
        if (!$type) {
            return json_encode([
                'status' => 'fail',
            ]);
        }
        $elements = AdditionalService::findAll(['type' => $type]);
        return json_encode([
            'status' => 'ok',
            'array' => ArrayHelper::map($elements, 'id', 'title'),
        ]);
    }

    public function actionCountPrice($id)
    {
        $reserve = Reserve::findOne($id);
        if ($reserve) {
            return json_encode(CountReservePriceService::countPrice($reserve));
        }
    }

    public function actionStatusChange()
    {
        $id = Yii::$app->request->post('id');
        $reserve = Reserve::findOne($id);
        if (!$reserve) {
            return json_encode([
                'status' => 'fail',
                'message' => 'Резевр не найден',
            ]);
        } else {
            if (!$reserve->client || $reserve->client->status != Client::STATUS_VERIFIED) {
                return json_encode([
                    'status' => 'fail',
                    'message' => 'Клиент не подтвержден!',
                ]);
            }
            $status = Yii::$app->request->post('status');
            $reserve->status = $status;
            if ($reserve->save()) {
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

    public function actionLead()
    {
        $searchModel = new ReserveSearch();
        $dataProvider = $searchModel->searchLead(Yii::$app->request->queryParams);

        return $this->render('lead', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLeadCreate()
    {
        $model = new ReserveForm();
        $model->reserve = new Reserve();
        $model->reserve->lead_status = Reserve::LEAD_STATUS_OPEN;
        $model->reserve->status = Reserve::STATUS_ACCEPTED;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->reserve->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionLeadStatusChange()
    {
        $id = Yii::$app->request->post('id');
        $reserve = Reserve::findOne($id);
        if (!$reserve) {
            return json_encode([
                'status' => 'fail',
                'message' => 'Резевр не найден',
            ]);
        } else {
            $lead_status = Yii::$app->request->post('status');
            $reserve->lead_status = $lead_status;
            if ($reserve->save()) {
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

    public function actionGetTables($id)
    {
        $reserve = Reserve::findOne($id);
        if (!$reserve) {
            return json_encode([
                'status' => 'fail',
                'message' => 'Резерв не найден',
            ]);
        } else {
            return json_encode([
                'status' => 'ok',
                'info' => $this->renderPartial('_view', ['model' => $reserve]),
                'fines' => $this->renderPartial('fines/list', ['model' => $reserve]),
                'files' => $this->renderPartial('files/list', ['model' => $reserve]),
                'reserve_children' => $this->renderPartial('reserve_children/list', ['model' => $reserve]),
            ]);
        }
    }

    public function actionContract($id)
    {
        $reserve = Reserve::findOne($id);
        return $this->renderPartial('generate/contract', ['reserve' => $reserve]);
    }

    public function actionAct($id, $to_client = 0)
    {
        $reserve = Reserve::findOne($id);
        return $this->renderPartial('generate/act', [
            'reserve' => $reserve,
            'to_client' => $to_client,
        ]);
    }

    public function actionDefect($id, $to_client = 0)
    {
        $reserve = Reserve::findOne($id);
        return $this->renderPartial('generate/defect', [
            'reserve' => $reserve,
            'to_client' => $to_client,
        ]);
    }
}
