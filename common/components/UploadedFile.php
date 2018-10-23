<?php
namespace common\components;

use yii\web\ForbiddenHttpException;

/**
 * Class UploadedFile
 * @package common\components
 */
class UploadedFile extends \yii\web\UploadedFile
{
    /**
     * @var
     */
    public $pathToFile;

    /**
     * @var
     */
    public $base_path;

    /**
     * @var
     */
    public $relative_path;
    /**
     * @var
     */
    public $absolute_path;

    /**
     * @var array
     */
    public $allowedMimeTypes = ['image/jpg', 'image/png', 'image/jpeg'];
    /**
     * @var array
     */
    public $allowedExtensions = ['jpg', 'png', 'jpeg', 'doc', 'docx', 'txt', 'rtf', 'pdf', 'xsl'];


    /**
     *  Загруженный файл безопасный или нет
     */
    public function isNormalFile()
    {
        return (count(array_intersect(FileHelper::getExtensionsByMimeType($this->type), $this->allowedExtensions)) !== 0) && in_array($this->extension, $this->allowedExtensions);
    }

    

    /**
     * @param $basePath
     * @param $relativePath
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function saveImageAs($basePath, $relativePath)
    {
        if ($this->isNormalFile()) {
            $this->pathToFile = FileHelper::generateFilePath($basePath, $relativePath, $this->extension);
            return $this->saveAs(FileHelper::normalizePath($basePath . '/' . $this->pathToFile));
        }
        throw new ForbiddenHttpException('Тип файла не разрешен');
    }


    /**
     * @param $basePath
     * @param $relativePath
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function saveAnyFileAs($basePath, $relativePath)
    {
        if ($this->isNormalFile()) {
            $this->pathToFile = FileHelper::generateFilePath($basePath, $relativePath, $this->extension);
            return $this->saveAs(FileHelper::normalizePath($basePath . '/' . $this->pathToFile));
        }
        throw new ForbiddenHttpException('Тип файла не разрешен');
    }

    /**
     * @param string $name
     * @return \yii\web\UploadedFile
     */
    public static function getInstanceByName($name)
    {
        return parent::getInstanceByName($name);
    }

    /**
     *
     */
    public function getRelativeUrl()
    {
        return $this->pathToFile;
    }

    /**
     * @param $host
     * @return string
     */
    public function getAbsoluteUrl($host)
    {
        return $host . $this->pathToFile;
    }

    public function saveToServer()
    {
        $this->pathToFile = FileHelper::generateDeepFilePathNoExt(\Yii::getAlias('@webroot'), '/files/');
        return $this->saveAs(FileHelper::normalizePath(\Yii::getAlias('@webroot') . '/' . $this->pathToFile));
    }

}