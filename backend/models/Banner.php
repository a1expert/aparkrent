<?php

namespace backend\models;

use common\components\UploadedFile;
use Yii;
use yii\helpers\ArrayHelper;

class Banner extends \common\models\Banner
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
     * @throws \yii\web\ForbiddenHttpException
     */
    public function upload()
    {
        if ($this->file->saveImageAs(Yii::getAlias('@frontend/web'), '/images/uploads/banner/')) {
            $this->image = $this->file->getRelativeUrl();
            return true;
        }
        return false;
    }
}
