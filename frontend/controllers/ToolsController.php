<?php

namespace frontend\controllers;


use common\components\FileHelper;
use common\components\UploadedFile;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;

class ToolsController extends Controller
{
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
//        var_dump($transparent);die;
        imagefilledrectangle($dest_r, 0, 0, $defaultWidth, $defaultHeight, $transparent);
        /********end*********/
        $sizeImg = getimagesize($sourceImagePath);
        $widthImg = $sizeImg[0];
        $heightImg = $sizeImg[1];

        $def_width = $defaultWidth/$width*$widthImg;
        $def_height = $defaultHeight/$height*$heightImg;

        $dest_X = $defaultWidth/$width*$fromX;
        $dest_Y = $defaultHeight/$height*$fromY;
        if (!imagecopyresampled($dest_r, $image, -$dest_X, -$dest_Y, 0, 0, $def_width, $def_height, $widthImg, $heightImg)) {
            return false;
        }
//        if (!imagecopyresampled($dest_r, $image, 0, 0, $fromX, $fromY, $defaultWidth, $defaultHeight, $width, $height)) {
//            return false;
//        }
// save only png or jpeg pictures
        if ($file_type == 'jpg' || $file_type == 'jpeg') {
            imagejpeg($dest_r, $sourceImagePath, 81);
        } elseif ($file_type == 'png') {
            imagepng($dest_r, $sourceImagePath);
        }
        return true;
    }

    public function actionCrop()
    {
        if ($image = UploadedFile::getInstanceByName('image_file')) {
            $extension = strtolower($image->getExtension());
        } else {
            echo "Файл не выбран";
            return false;
        }

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $pathToFile = '/images/clientPhoto/' . Yii::$app->getSecurity()->generateRandomString() . '.' . $image->getExtension();
        } else {
            echo "Неверный формат. Разрешены только *.png, *.jpg, *.jpeg";
            return false;
        }
        try {
            $image->saveAs( Yii::getAlias('@webroot') . $pathToFile);
            self::cropImage(Yii::getAlias('@webroot') . $pathToFile, $_POST['crop_x'], $_POST['crop_y'], $_POST['crop_w'], $_POST['crop_h'], $_POST['width'], $_POST['height']);

            return json_encode([
                'link' => $pathToFile,
                'image' => $pathToFile,
            ]);

        } catch (Exception $e) {
            echo "Ошибка при сохранении. Обратитесь к администратору";
            return false;
        }
    }
    public function actionUploadTopImage()
    {
        return $this->renderAjax('/site/_modal');
    }
    public function actionUploadRegistrationImage()
    {
        try {
            if ($uploadedFile = UploadedFile::getInstanceByName('image_files')) {
                if ($uploadedFile->saveImageAs(\Yii::getAlias('@webroot'), '/images/uploads/reserve')) {
                    return Json::encode([
                        'filename' => $uploadedFile->getRelativeUrl(),
                        'preview_url' => $uploadedFile->getRelativeUrl(),
                    ]);
                }
//                if ($uploadedFile->saveToServer()) {
//                    return Json::encode(array(
//                        'filename' => $uploadedFile->getRelativeUrl(),
//                    ));
//                }
            }
        } catch (Exception $e) {
            return 'Ошибка при загрузке: ' .  $e->getMessage();
        }
        return 'Ошибка при загрузке';
    }
    /**
     * @return bool
     */
    public function actionCropRegistrationImage()
    {
//        $adminSiteDirectory = \Yii::getAlias('@backend/web');
//        $siteDirectory = \Yii::getAlias('@frontend/web');
        $siteDirectory = \Yii::getAlias('@webroot');
//        $siteHost = \Yii::$app->params['realtyDreamsHost'];
        try {
            if ($_POST['new_image']) {
                if ($image = UploadedFile::getInstanceByName('image_file')) {
                    $extension = strtolower($image->getExtension());
                } else {
                    echo "Файл не выбран";
                    return false;
                }

                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
                    if ($_POST['path'] == 'photogallery') {
                        $pathToFile = 'images/'.$_POST['path'].'/' . FileHelper::getRandomFileName(\Yii::getAlias('@webroot') . '/images/'.$_POST['path'].'/' , $image->getExtension())  . '.' . $image->getExtension();
                    } else {
                        $pathToFile = '/images/'.$_POST['path'].'/' . FileHelper::getRandomFileName(\Yii::getAlias('@webroot') . '/images/'.$_POST['path'].'/' , $image->getExtension())  . '.' . $image->getExtension();
                    }
                } else {
                    echo "Неверный формат. Разрешены только *.png, *.jpg, *.jpeg";
                    return false;
                }
                if ($_POST['path'] == 'photogallery') {
                    $image->saveAs($siteDirectory .'/'. $pathToFile);
                } else {
                    $image->saveAs($siteDirectory . $pathToFile);
                }
//                copy($siteDirectory . $pathToFile, $adminSiteDirectory . $pathToFile);
            } else {
                $pathToFile = $_POST['image_file'];
                $newPathToFile = '/images/top/' . FileHelper::getRandomFileName(\Yii::getAlias('@webroot') . '/images/top/' , strtolower(pathinfo($siteDirectory . $pathToFile, PATHINFO_EXTENSION)))  . '.' . strtolower(pathinfo($siteDirectory . $pathToFile, PATHINFO_EXTENSION));;
//                copy($adminSiteDirectory . $pathToFile, $siteDirectory  . $newPathToFile);
                $pathToFile = $newPathToFile;
            }

            if ($_POST['path'] == 'photogallery') {
                self::cropImage($siteDirectory .'/'. $pathToFile, $_POST['crop_x'], $_POST['crop_y'], $_POST['crop_w'], $_POST['crop_h'], $_POST['width'], $_POST['height']);
            } else {
                self::cropImage($siteDirectory . $pathToFile, $_POST['crop_x'], $_POST['crop_y'], $_POST['crop_w'], $_POST['crop_h'], $_POST['width'], $_POST['height']);
            }


            $data = array();
            $data['imageBaseName'] = strtolower(pathinfo($siteDirectory . $pathToFile, PATHINFO_BASENAME));
            $data['link'] = $pathToFile;
            $data['image'] = $pathToFile;
            return json_encode($data);

        } catch (Exception $e) {
            echo "Ошибка при сохранении. Обратитесь к администратору";
            return false;
        }
    }
    public function actionCropVacancy()
    {
        if ($image = UploadedFile::getInstanceByName('image_file')) {
            $extension = strtolower($image->getExtension());
        } else {
            echo "Файл не выбран";
            return false;
        }

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $pathToFile = '/images/vacancy/' . Yii::$app->getSecurity()->generateRandomString() . '.' . $image->getExtension();
        } else {
            echo "Неверный формат. Разрешены только *.png, *.jpg, *.jpeg";
            return false;
        }

        try {
            $image->saveAs( Yii::getAlias('@webroot') . $pathToFile);
            self::cropImage(Yii::getAlias('@webroot') . $pathToFile, $_POST['crop_x'], $_POST['crop_y'], $_POST['crop_w'], $_POST['crop_h'], $_POST['width'], $_POST['height']);

            return json_encode([
                'link' => $pathToFile,
                'image' => $pathToFile,
            ]);

        } catch (Exception $e) {
            echo "Ошибка при сохранении. Обратитесь к администратору";
            return false;
        }
    }
    public function actionCropCoverImage()
    {
        if ($image = UploadedFile::getInstanceByName('image_file')) {
            $extension = strtolower($image->getExtension());
        } else {
            echo "Файл не выбран";
            return false;
        }

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $pathToFile = '/images/clientPhoto/' . Yii::$app->getSecurity()->generateRandomString() . '.' . $image->getExtension();
        } else {
            echo "Неверный формат. Разрешены только *.png, *.jpg, *.jpeg";
            return false;
        }

        try {
            $image->saveAs( Yii::getAlias('@webroot') . $pathToFile);
            self::cropImage(Yii::getAlias('@webroot') . $pathToFile, $_POST['crop_x'], $_POST['crop_y'], $_POST['crop_w'], $_POST['crop_h'], $_POST['width'], $_POST['height']);

            return json_encode([
                'link' => $pathToFile,
                'image' => $pathToFile,
            ]);

        } catch (Exception $e) {
            echo "Ошибка при сохранении. Обратитесь к администратору";
            return false;
        }
    }
}