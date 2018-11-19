<?php
namespace frontend\controllers;

use frontend\models\AdditionalService;
use frontend\models\AutoClass;
use frontend\models\AutoMark;
use frontend\models\AutoModel;
use frontend\models\Reserve;
use frontend\forms\CallbackForm;
use frontend\forms\SearchForm;
use frontend\payment\Sberbank;
use frontend\services\CheckForSberbankService;
use yii\bootstrap\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $searchForm = new SearchForm();
        if (\Yii::$app->request->isAjax) {
            if ($searchForm->load(\Yii::$app->request->post()) && $searchForm->validate()) {
                $models = AutoModel::find()
                    ->andFilterWhere(['class_id' => $searchForm->class_id])
                    ->andWhere(['not', ['mark_id' => null]])
                    ->andWhere(['visibility' => AutoModel::VISIBILITY_VISIBLE])
                    ->orderBy('sort ASC')
                    ->all();
                return json_encode([
                    'status' => 'ok',
                    'content' => $this->renderPartial('_main_search', [
                        'models' => $models,
                    ]),
                ]);
            }
        }
        $classes = AutoClass::find()->orderBy('sort')->all();
        $models = AutoModel::find()
            ->andWhere(['not', ['mark_id' => null]])
            ->andWhere(['visibility' => AutoModel::VISIBILITY_VISIBLE])
            ->orderBy('sort ASC')
            ->all();
        return $this->render('index', [
            'models' => $models,
            'classes' => $classes,
            'searchForm' => $searchForm,
        ]);
    }

    public function actionCatalog()
    {
        if (\Yii::$app->request->isAjax) {
            $markArray = \Yii::$app->request->post('markArray');
            if ($markArray != null) {
                $markArray = explode(' ', $markArray);
            }
            $models = AutoModel::find()
                ->filterWhere(['mark_id' => $markArray])
                ->andWhere(['not', ['mark_id' => null]])
                ->andWhere(['visibility' => AutoModel::VISIBILITY_VISIBLE])
                ->orderBy('sort ASC')
                ->all();
            return json_encode([
                'status' => 'ok',
                'content' => $this->renderPartial('_cars', [
                    'models' => $models,
                ]),
            ]);
        }
        $marks = AutoMark::find()->all();
        $models = AutoModel::find()
            ->andWhere(['not', ['mark_id' => null]])
            ->andWhere(['visibility' => AutoModel::VISIBILITY_VISIBLE])
            ->orderBy('sort ASC')
            ->all();
        return $this->render('catalog', [
            'marks' => $marks,
            'models' => $models,
        ]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionJobs()
    {
        $deliveryType = AdditionalService::find()->where(['type' => AdditionalService::TYPE_DELIVERY])->all();
        $wash = AdditionalService::find()->where(['type' => AdditionalService::TYPE_WASH])->one();
        $expressWash = AdditionalService::find()->where(['type' => AdditionalService::TYPE_EXPRESS_WASH])->one();
        $rentType = AdditionalService::find()->where(['type' => AdditionalService::TYPE_RENT])->all();
        return $this->render('jobs', [
            'deliveryType' => $deliveryType,
            'wash' => $wash,
            'expressWash' => $expressWash,
            'rentType' => $rentType,
        ]);
    }

    public function actionConditions()
    {
        return $this->render('conditions');
    }

    public function actionReserve($id)
    {
        $model = AutoModel::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $this->render('reserve', [
            'model' => $model,
        ]);
    }

    public function actionCallback()
    {
        $form = new CallbackForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate() && $form->sendMessage()) {
            return json_encode([
                'status' => 'ok',
                'message' => 'Ваше сообщение успешно отправлено!',
            ]);
        }
        if ($form->hasErrors()) {
            return json_encode([
                'status' => 'fail',
                'message' => Html::errorSummary($form),
            ]);
        }
        return json_encode([
            'status' => 'fail',
            'message' => 'Произошла ошибка, попробуйте повторить позже.',
        ]);
    }
}
