<?php

namespace backend\controllers;

use common\components\UploadedFile;
use Exception;
use Yii;
use yii\web\Controller;


class UploadController extends Controller
{
    public function actionImage()
    {

        $uploadedFile;

        try {
            if ($uploadedFile = UploadedFile::getInstanceByName('photo')) {
                if ($uploadedFile->saveImageAs(\Yii::getAlias('@frontend/web'), '/images/uploads/gallery')) {
                    $filename = $uploadedFile->getRelativeUrl();
                    return json_encode([
                        'filename' => $filename,
                        'preview_url' => Yii::$app->params['frontend'] . $filename,
                        'for_crop' => 'data:image/' . pathinfo(Yii::getAlias('@frontend/web') . $filename, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(Yii::getAlias('@frontend/web') . $filename)),
                    ]);
                }
            }

        } catch (Exception $e) {
            return 'Ошибка при загрузке: ' .  $e->getMessage();
        }

        var_dump($uploadedFile);die;
        return 'Ошибка при загрузке 1';

    }
}