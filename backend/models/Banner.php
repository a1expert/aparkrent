<?php

namespace backend\models;

use Yii;

class Banner extends \common\models\Banner
{
    const IMAGE_WIDTH = 1920;
    const IMAGE_HEIGHT = 600;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'string'],
            [['title_1', 'title_2'], 'string', 'max' => 255],
        ];
    }

    public function getImageFrontEnd()
    {
        if ($this->image == '') {
            return '/images/no_photo.png';
        }

        return Yii::getAlias('@frontend/web') . $this->image;
    }
}
