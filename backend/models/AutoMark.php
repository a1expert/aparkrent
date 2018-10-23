<?php

namespace backend\models;

use common\components\UploadedFile;
use Yii;
use yii\helpers\ArrayHelper;

class AutoMark extends \common\models\AutoMark
{
    /**
     * @var UploadedFile $file
     */
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['file'], 'safe'],
        ]);
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->file->saveImageAs(Yii::getAlias('@frontend/web'), '/images/uploads/logo/')) {
            $this->logo = $this->file->getRelativeUrl();
            return true;
        }
        return false;
    }
}
