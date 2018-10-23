<?php

namespace cabinet\controllers;

use cabinet\components\CabinetController;
use cabinet\forms\LoginForm;
use cabinet\forms\PasswordChangeForm;
use cabinet\forms\RestoreForm;
use cabinet\models\User;
use yii\web\NotFoundHttpException;

class UserController extends CabinetController
{
    public function actionLogin($phone = null)
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->login = $phone;
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRestore()
    {
        $this->layout = 'login';
        $model = new RestoreForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->sendCode();
            return $this->redirect(['/user/enter-code', 'phone' => $model->phone]);
        }
        return $this->render('restore', ['model' => $model]);
    }

    public function actionEnterCode($phone)
    {
        $this->layout = 'login';
        $model = new RestoreForm();
        $model->scenario = RestoreForm::SCENARIO_RESET_CODE_SEND;
        $model->phone = $phone;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['/user/enter-new-password', 'code' => $model->reset_token, 'phone' => $model->phone]);
        }
        return $this->render('enter_code', ['model' => $model]);
    }

    public function actionEnterNewPassword($code, $phone)
    {
        $this->layout = 'login';
        if (!\Yii::$app->security->validatePassword($code, User::findByPhone($phone)->password_reset_token)) {
            throw new NotFoundHttpException();
        }
        $model = new RestoreForm();
        $model->scenario = RestoreForm::SCENARIO_RESET_CODE_SUCCESS;
        $model->phone = $phone;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->setNewPassword();
            return $this->redirect(['/user/login', 'phone' => $phone]);
        }
        return $this->render('enter_new_password', ['model' => $model]);
    }

    public function actionChangePassword()
    {
        $this->viewPath = \Yii::getAlias('@cabinet/views/setting');
        $form = new PasswordChangeForm();
        if ($form->load(\Yii::$app->request->post()) && $form->changePassword()) {
            $form = new PasswordChangeForm();
            return json_encode([
                'status' => 'ok',
                'message' => 'Пароль успешно изменен',
                'content' => $this->renderPartial('_change_password', ['passwordChanger' => $form]),
            ]);
        } else {
            return json_encode([
                'status' => 'fail',
                'content' => $this->renderPartial('_change_password', ['passwordChanger' => $form]),
            ]);
        }
    }
}