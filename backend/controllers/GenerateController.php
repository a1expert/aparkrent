<?php

namespace backend\controllers;

use backend\models\Reserve;
use backend\models\ReserveFileType;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Created at 18.12.2017 19:09
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

class GenerateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
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

    public function actionGenerate($file_type_id, $reserve_id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $type = ReserveFileType::find()->where(['id' => $file_type_id])->one();
        if ($type && $type->generate_type != '') {
            $reserve = Reserve::findOne($reserve_id);
            if ($reserve) {
                switch ($type->generate_type) {
                    case 'contract':
                        return $this->generateContract($reserve);
                    case 'act':
                        return $this->generateAct($reserve, $type->to_client);
                    case 'defect':
                        return $this->generateDefect($reserve, $type->to_client);
                }
            }
            return [
                'status' => 'fail',
                'message' => 'Резерв не найден',
            ];
        }
        return [
            'status' => 'fail',
            'message' => 'Неподходящий для генерации документ',
        ];
    }

    private function generateContract($reserve)
    {
        $documentHtmlPath = '/document/html/contract_to_reserve_' . $reserve->id . '.html';
        file_put_contents(\Yii::getAlias('@frontend/web') . $documentHtmlPath, $this->renderPartial('contract', ['reserve' => $reserve]));
        $documentPdfPath = '/document/pdf/contract_to_reserve_' . $reserve->id . '.pdf';

        exec("/var/www/darok/data/wkhtmltox/bin/wkhtmltopdf --page-size A4 --dpi 75 --print-media-type "
            . \Yii::getAlias('@frontend/web') . $documentHtmlPath
            . " "
            . \Yii::getAlias('@frontend/web') . $documentPdfPath, $array, $return);

        if ($return) {
            return [
                'status' => 'fail',
                'message' => 'Ошибка генерации файла',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Файл успешно сгенерирован',
            'filename' => 'contract_to_reserve_' . $reserve->id . '.pdf',
            'filepath' => $documentPdfPath,
        ];
    }

    private function generateAct($reserve, $to_client = 0)
    {
        $documentHtmlPath = '/document/html/act_' . ($to_client ? 'to' : 'from') . '_client_to_reserve_' . $reserve->id . '.html';
        file_put_contents(\Yii::getAlias('@frontend/web') . $documentHtmlPath, $this->renderPartial('act', ['reserve' => $reserve, 'to_client' => $to_client]));
        $documentPdfPath = '/document/pdf/act_' . ($to_client ? 'to' : 'from') . '_client_to_reserve_' . $reserve->id . '.pdf';

        exec("/var/www/darok/data/wkhtmltox/bin/wkhtmltopdf --page-size A4 --dpi 75 --print-media-type "
            . \Yii::getAlias('@frontend/web') . $documentHtmlPath
            . " "
            . \Yii::getAlias('@frontend/web') . $documentPdfPath, $array, $return);

        if ($return) {
            return [
                'status' => 'fail',
                'message' => 'Ошибка генерации файла',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Файл успешно сгенерирован',
            'filename' => 'act_' . ($to_client ? 'to' : 'from') . '_client_to_reserve_' . $reserve->id . '.pdf',
            'filepath' => $documentPdfPath,
        ];
    }

    private function generateDefect($reserve, $to_client = 0)
    {
        $documentHtmlPath = '/document/html/defect_' . ($to_client ? 'to' : 'from') . '_client_to_reserve_' . $reserve->id . '.html';
        file_put_contents(\Yii::getAlias('@frontend/web') . $documentHtmlPath, $this->renderPartial('defect', ['reserve' => $reserve, 'to_client' => $to_client]));
        $documentPdfPath = '/document/pdf/defect_' . ($to_client ? 'to' : 'from') . '_client_to_reserve_' . $reserve->id . '.pdf';

        exec("/var/www/darok/data/wkhtmltox/bin/wkhtmltopdf --page-size A4 --dpi 75 --print-media-type "
            . \Yii::getAlias('@frontend/web') . $documentHtmlPath
            . " "
            . \Yii::getAlias('@frontend/web') . $documentPdfPath, $array, $return);

        if ($return) {
            return [
                'status' => 'fail',
                'message' => 'Ошибка генерации файла',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Файл успешно сгенерирован',
            'filename' => 'defect_' . ($to_client ? 'to' : 'from') . '_client_to_reserve_' . $reserve->id . '.pdf',
            'filepath' => $documentPdfPath,
        ];
    }
}