<?php
/**
 * Created at 07.11.2017 16:28
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\controllers;


use backend\forms\ReserveChildrenForm;
use backend\models\Reserve;
use backend\models\ReserveChild;
use backend\services\CountReservePriceService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ReserveChildController extends Controller
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

    public function actionCreate($id)
    {
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $childForm = new ReserveChildrenForm();
        $childForm->child = new ReserveChild();
        $childForm->reserve_id = $id;
        if ($childForm->load(Yii::$app->request->post()) && $childForm->save()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
            ]);
        } else {
            $reserve = Reserve::findOne($id);
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('reserve_children/_form', [
                    'model' => $reserve,
                    'childForm' => $childForm,
                ]),
            ]);
        }
    }

    public function actionRefresh($id, $child_id = null)
    {
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $childForm = new ReserveChildrenForm();
        if (!$childForm->child = ReserveChild::findOne($child_id)) {
            $childForm->child = new ReserveChild();
        } else {
            $childForm->setChildForm($childForm->child);
        }
        $childForm->reserve_id = $id;
        $childForm->load(Yii::$app->request->post());
        $reserve = Reserve::findOne($id);
        return json_encode([
            'status' => 'ok',
            'content' => $this->renderAjax('reserve_children/_form', [
                'model' => $reserve,
                'childForm' => $childForm,
            ]),
        ]);
    }

    public function actionUpdate($id)
    {
        $this->viewPath = Yii::getAlias('@backend/views/reserve');
        $child = ReserveChild::findOne($id);
        $childForm = new ReserveChildrenForm();
        $childForm->setChildForm($child);
        if ($childForm->load(Yii::$app->request->post()) && $childForm->save()) {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'true',
            ]);
        } else {
            return json_encode([
                'status' => 'ok',
                'loaded' => 'false',
                'content' => $this->renderAjax('reserve_children/_form', [
                    'model' => $childForm->child->reserve,
                    'childForm' => $childForm,
                ]),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $child = ReserveChild::findOne($id);
        $child->status = ReserveChild::STATUS_DELETED;
        $child->save(false);
        return json_encode([
            'status' => 'ok',
        ]);
    }

    public function actionCount()
    {
        return json_encode(CountReservePriceService::countPriceForChild(ReserveChild::findOne(Yii::$app->request->post('id'))));
    }
}