<?php

namespace cabinet\components;

use yii\web\Controller;

/**
 * Created at 05.12.2017 17:16
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
class CabinetController extends Controller
{
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest && \Yii::$app->controller->action->id != 'login') {
            $this->redirect('/user/login');
            \Yii::$app->end();
        }
        return parent::beforeAction($action);
    }
}