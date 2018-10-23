<?php

namespace cabinet\controllers;

use cabinet\components\CabinetController;
use cabinet\forms\PasswordChangeForm;
use cabinet\services\ClientChangesService;
use Yii;

/**
 * Created at 05.12.2017 17:28
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

class SettingController extends CabinetController
{
    public function actionPrivate()
    {
        $passwordChanger = new PasswordChangeForm();
        return $this->render('private', ['passwordChanger' => $passwordChanger]);
    }

    public function actionPersonal()
    {
        $message = '';
        $client = Yii::$app->user->identity->client;
        if ($client->load(\Yii::$app->request->post()) && $client->validate()) {
            $service = new ClientChangesService();
            $service->client = $client;
            $changesCount = $service->setChangeModels();
            $message = 'Мы зафискировали ' . \Yii::t('app', '{n, plural, one{# изменение} few{# изменения} many{# изменений} other{# изменений}}', ['n' => $changesCount]) . '. Данные будут обновлены при условии успешной модерации.';
        }
        return $this->render('personal', [
            'client' => $client,
            'message' => $message,
        ]);
    }
}