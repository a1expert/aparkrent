<?php
namespace backend\controllers;

use backend\components\DFileHelper;
use backend\forms\LoginForm;
use common\components\UploadedFile;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    public $layout = 'main';

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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCrop()
    {
        $siteDirectory = \Yii::getAlias('@frontend/web');
        $siteHost = \Yii::$app->urlManagerFrontEnd->hostInfo;

        if ($image = UploadedFile::getInstanceByName('image_file')) {
            $extension = strtolower($image->getExtension());
        } else {
            echo "Файл не выбран";
            return false;
        }

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $pathToFile = '/files/images/' . \common\components\DFileHelper::getRandomFileName(\Yii::getAlias('@frontend/web') . '/files/images/' , $image->getExtension())  . '.' . $image->getExtension();
        } else {
            echo "Неверный формат. Разрешены только *.png, *.jpg, *.jpeg";
            return false;
        }

        try {
            $image->saveAs($siteDirectory . $pathToFile);

            self::cropImage($siteDirectory . $pathToFile, $_POST['crop_x'], $_POST['crop_y'], $_POST['crop_w'], $_POST['crop_h'], $_POST['width'], $_POST['height']);


            $data = array();
            $data['link'] = $pathToFile;
            $data['image'] = $siteHost . $pathToFile;

            return json_encode($data);

        } catch (Exception $e) {
            echo "Ошибка при сохранении. Обратитесь к администратору";
            return false;
        }
    }

    public static function cropImage($sourceImagePath, $fromX = 0, $fromY = 0, $width = 0, $height = 0, $defaultWidth = 0, $defaultHeight = 0)
    {
        $file_type = pathinfo($sourceImagePath, PATHINFO_EXTENSION);

        if ($file_type == 'jpg' || $file_type == 'jpeg') {
            $image = imagecreatefromjpeg($sourceImagePath);
        } elseif ($file_type == 'png') {
            $image = imagecreatefrompng($sourceImagePath);
        } else {
            return false;
        }

        $dest_r = imagecreatetruecolor($defaultWidth, $defaultHeight);
        /******* Add these 2 lines maintain transparency of PNG images ****/
        imagealphablending($dest_r, false);
        imagesavealpha($dest_r, true);
        $transparent = imagecolorallocatealpha($dest_r, 255, 255, 255, 127);
        imagefilledrectangle($dest_r, 0, 0, $defaultWidth, $defaultHeight, $transparent);
        /********end*********/

        list($imgW,$imgH) = getimagesize($sourceImagePath);
        $srcX = 0;
        $srcY = 0;
        $dstX = -$fromX * $defaultWidth/$width;
        $dstY = -$fromY * $defaultHeight/$height;
        $srcW = $imgW;
        $srcH = $imgH;
        if (!imagecopyresampled($dest_r, $image, $dstX, $dstY, $srcX, $srcY, $srcW*$defaultWidth/$width, $srcH* $defaultHeight/$height, $srcW, $srcH)) {
            return false;
        }
        // save only png or jpeg pictures
        if ($file_type == 'jpg' || $file_type == 'jpeg') {
            imagejpeg($dest_r, $sourceImagePath, 100);
        } elseif ($file_type == 'png') {
            imagepng($dest_r, $sourceImagePath);
        }
        return true;
    }
}
