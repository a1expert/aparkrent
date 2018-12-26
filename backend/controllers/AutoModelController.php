<?php

namespace backend\controllers;

use backend\models\ModelGallery;
use common\components\UploadedFile;
use Yii;
use backend\models\AutoModel;
use backend\models\search\AutoModelSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * AutoModelController implements the CRUD actions for AutoModel model.
 */
class AutoModelController extends Controller
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
     * Lists all AutoModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AutoModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AutoModel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AutoModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AutoModel();
        $existing_gallery = null;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload() && $model->save()) {
                $model->crop();
                ModelGallery::saveGallery(Yii::$app->request->post('ModelGallery')['arrayImages'], $model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', ['model' => $model]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'existing_gallery' => $existing_gallery,
            ]);
        }
    }

    /**
     * Updates an existing AutoModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $existing_gallery = $model->modelGallery;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $upload_image = UploadedFile::getInstance($model, 'file');
            ModelGallery::saveGallery(Yii::$app->request->post('ModelGallery')['arrayImages'], $model->id);
            if (!empty($upload_image)) {
                $model->file = $upload_image;
                $model->upload();
                $model->crop();
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'existing_gallery' => $existing_gallery,
        ]);
    }

    /**
     * Deletes an existing AutoModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AutoModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AutoModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AutoModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
