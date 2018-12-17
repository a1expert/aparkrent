<?php
namespace common\components;
use Exception;

/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DFileHelper
{
    public static function getRandomFileName($path, $extension = '', $fullPath = false)
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return ($fullPath === false) ? $name : $file;
    }

    public static function getRandomFileNameWithPath($path, $extension = '', $host = '')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($host . $file));

        return $file;
    }

    public static function addWaterMark($sourceImagePath)
    {
        try {
            if (mime_content_type($sourceImagePath) == 'image/jpeg') {
                $image = imagecreatefromjpeg($sourceImagePath);
            } elseif (mime_content_type($sourceImagePath) == 'image/png') {
                $image = imagecreatefrompng($sourceImagePath);
            } else {
                return false;
            }

            list($imageWidth, $imageHeight) = getimagesize($sourceImagePath);

            // Сначала создаем наше изображение штампа вручную с помощью GD
            $watermarkPath = 'img/watermark.png';
            $stamp = imagecreatefrompng($watermarkPath);

            list($watermarkWidth, $watermarkHeight) = getimagesize($watermarkPath);
            $watermarkAspect = $watermarkWidth / $watermarkHeight;
            $imageAspect = $imageWidth / $imageHeight;

            if ($watermarkAspect < $imageAspect) {
                //по высоте впритык
                $newWatermarkHeight = $imageHeight / 3 * 2;
                $marginTop = $imageHeight / 6;

                $newWatermarkWidth = $newWatermarkHeight * $watermarkAspect;
                $marginLeft = (int)($imageWidth - $newWatermarkWidth) / 2;
            } else {
                //по высоте впритык
                $newWatermarkWidth = (int)$imageWidth / 3 * 2;
                $marginLeft = (int)$imageWidth / 6;

                $newWatermarkHeight = $newWatermarkWidth / $watermarkAspect;
                $marginTop = (int)($imageHeight - $newWatermarkHeight) / 2;
            }
            $newWatermark = imagecreatetruecolor($newWatermarkWidth, $newWatermarkHeight);
            imagealphablending($newWatermark, false);
            imagesavealpha($newWatermark, true);
            $transparent = imagecolorallocatealpha($newWatermark, 255, 255, 255, 127);
            imagefilledrectangle($newWatermark, 0, 0, $newWatermarkWidth, $newWatermarkHeight, $transparent);
            imagecopyresampled($newWatermark, $stamp, 0, 0, 0, 0, $newWatermarkWidth, $newWatermarkHeight, $watermarkWidth, $watermarkHeight);
            imagealphablending($newWatermark, true);
            imagealphablending($image, true);

            // Слияние штампа с фотографией

            imagecopy($image, $newWatermark, $marginLeft, $marginTop, 0, 0, $newWatermarkWidth, $newWatermarkHeight);

            // save only png or jpeg pictures
            if (mime_content_type($sourceImagePath) == 'image/jpeg') {
                imagejpeg($image, $sourceImagePath, 81);
            } elseif (mime_content_type($sourceImagePath) == 'image/png') {
                imagepng($image, $sourceImagePath);
            }
            return true;
        } catch (Exception $e) {
            echo 'Ошибка добавлении водяного знака: ', $e->getMessage(), "\n";
        }
        return true;
    }

    public static function resizeImage($sourceImagePath)
    {
        $newWidth = 1024;
        $newHeight = 768;
        list($imageWidth, $imageHeight) = getimagesize($sourceImagePath);
        if (($imageWidth <= $newWidth) && ($imageHeight <= $newHeight)) return true;
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            $image = imagecreatefromjpeg($sourceImagePath);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
            $image = imagecreatefrompng($sourceImagePath);
        } else {
            return false;
        }

        $sourceRatio = $imageWidth / $imageHeight;

        if ($imageWidth < $imageHeight) {
            //тогда высота новое изображение подходит по ширине, но не подходит по высоте (новое меньше), значит обрезаем по высоте
            $newTempHeight = $newHeight;
            $newTempWidth = $newHeight * $sourceRatio;
        } else {
            //тогда высота нового изображения подходит, но ширина нового, меньше, значит обрезаем по ширине
            $newTempWidth = $newWidth;
            $newTempHeight = (int)($newWidth / $sourceRatio);
        }

        $dest_r = imagecreatetruecolor($newTempWidth, $newTempHeight);
        /******* Add these 2 lines maintain transparency of PNG images ****/
        imagealphablending($dest_r, false);
        imagesavealpha($dest_r, true);
        $transparent = imagecolorallocatealpha($dest_r, 255, 255, 255, 127);
        imagefilledrectangle($dest_r, 0, 0, $newTempWidth, $newTempHeight, $transparent);
        /********end*********/

        if (!imagecopyresampled($dest_r, $image, 0, 0, 0, 0, $newTempWidth, $newTempHeight, $imageWidth, $imageHeight)) {
            return false;
        }
        // save only png or jpeg pictures
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            imagejpeg($dest_r, $sourceImagePath, 81);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
            imagepng($dest_r, $sourceImagePath);
        }
        return true;

    }

    public static function cropImageWithWaterMark($sourceImagePath, $fromX = 0, $fromY = 0, $width = 0, $height = 0, $defaultWidth = 0, $defaultHeight = 0)
    {
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            $image = imagecreatefromjpeg($sourceImagePath);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
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

        if (!imagecopyresampled($dest_r, $image, 0, 0, $fromX, $fromY, $defaultWidth, $defaultHeight, $width, $height)) {
            return false;
        }

        // Сначала создаем наше изображение штампа вручную с помощью GD
        $stamp = imagecreatefrompng('img/watermark.png');

        // Установка полей для штампа и получение высоты/ширины штампа
        $marge_right = 10;
        $marge_top = 10;
        $sx = 74;
        $sy = 65;

        imagealphablending($stamp, true);
        imagealphablending($dest_r, true);

        // Слияние штампа с фотографией
        imagecopy($dest_r, $stamp, $defaultWidth - $sx - $marge_right, $marge_top, 0, 0, $sx, $sy);

        // save only png or jpeg pictures
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            imagejpeg($dest_r, $sourceImagePath, 81);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
            imagepng($dest_r, $sourceImagePath);
        }
        return true;
    }

    public static function cropImage($sourceImagePath, $fromX = 0, $fromY = 0, $width = 0, $height = 0, $defaultWidth = 0, $defaultHeight = 0)
    {
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            $image = imagecreatefromjpeg($sourceImagePath);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
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

        if (!imagecopyresampled($dest_r, $image, 0, 0, $fromX, $fromY, $defaultWidth, $defaultHeight, $width, $height)) {
            return false;
        }
        // save only png or jpeg pictures
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            imagejpeg($dest_r, $sourceImagePath, 100);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
            imagepng($dest_r, $sourceImagePath);
        }
        return true;
    }

    public static function getThumbFromImage($sourceImagePath, $newWidth = 0, $newHeight = 0)
    {
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            $image = imagecreatefromjpeg($sourceImagePath);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
            $image = imagecreatefrompng($sourceImagePath);
        } else {
            return false;
        }

        $dest_r = imagecreatetruecolor($newWidth, $newHeight);
        /******* Add these 2 lines maintain transparency of PNG images ****/
        imagealphablending($dest_r, false);
        imagesavealpha($dest_r, true);
        $transparent = imagecolorallocatealpha($dest_r, 255, 255, 255, 127);
        imagefilledrectangle($dest_r, 0, 0, $newWidth, $newHeight, $transparent);
        /********end*********/

        list($imageWidth, $imageHeight) = getimagesize($sourceImagePath);

        $destRatio = $newWidth / $newHeight;

        if ($imageWidth / $destRatio < $imageHeight) {
            //тогда высота новое изображение подходит по ширине, но не подходит по высоте (новое меньше), значит обрезаем по высоте
            $newTempWidth = (int)$imageWidth;
            $newTempHeight = (int)($imageWidth / $destRatio);
            $fromX = 0;
            $fromY = (int)(($imageHeight - $imageWidth / $destRatio) / 2);
        } else {
            //тогда высота нового изображения подходит, но ширина нового, меньше, значит обрезаем по ширине
            $newTempWidth = (int)($imageHeight * $destRatio);
            $newTempHeight = $imageHeight;
            $fromX = (int)(($imageWidth - $imageHeight * $destRatio) / 2);
            $fromY = 0;
        }

        if (!imagecopyresampled($dest_r, $image, 0, 0, $fromX, $fromY, $newWidth, $newHeight, $newTempWidth, $newTempHeight)) {
            return false;
        }
        // save only png or jpeg pictures
        if (mime_content_type($sourceImagePath) == 'image/jpeg') {
            imagejpeg($dest_r, $sourceImagePath, 100);
        } elseif (mime_content_type($sourceImagePath) == 'image/png') {
            imagepng($dest_r, $sourceImagePath);
        }
        return true;
    }

    public static function grayscaleImage($filename)
    {
        //Получаем размеры изображения
        $img_size = GetImageSize($filename);
        $width = $img_size[0];
        $height = $img_size[1];
        //Создаем новое изображение с такмими же размерами
        $img = imageCreate($width, $height);
        //Задаем новому изображению палитру "оттенки серого" (grayscale)
        for ($c = 0; $c < 256; $c++) {
            ImageColorAllocate($img, $c, $c, $c);
        }
        //Содаем изображение из файла
        if (mime_content_type($filename) == 'image/jpeg') {
            $img2 = imagecreatefromjpeg($filename);
        } elseif (mime_content_type($filename) == 'image/png') {
            $img2 = imagecreatefrompng($filename);
        } else {
            return false;
        }
        //Объединяем два изображения
        ImageCopyMerge($img, $img2, 0, 0, 0, 0, $width, $height, 100);
        //Сохраняем полученное изображение
        if (mime_content_type($filename) == 'image/jpeg') {
            imagejpeg($img, $filename, 100);
        } elseif (mime_content_type($filename) == 'image/png') {
            imagepng($img, $filename);
        }
        return true;
    }
}
