<?php

namespace backend\models;

use common\components\FileHelper;
use common\components\UploadedFile;
use Yii;

/**
 * @property AutoClass $class
 * @property AutoMark $mark
 * @property Tariff[] $tariffs
 *
 * @property string $fullTitle
 */
class AutoModel extends \common\models\AutoModel
{
    public $file;
    public $cropX;
    public $cropY;
    public $cropWidth;
    public $cropHeight;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['mark_id', 'class_id', 'status', 'conditioner', 'sort', 'visibility', 'transmission', 'climate_control', 'heating'], 'integer'],
            [['title', 'image', 'equipment', 'engine', 'audio'], 'string', 'max' => 255],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoMark::className(), 'targetAttribute' => ['mark_id' => 'id']],
            [['file', 'cropX', 'cropY', 'cropWidth', 'cropHeight'], 'safe'],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(AutoClass::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasOne(AutoMark::className(), ['id' => 'mark_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffs()
    {
        return $this->hasMany(Tariff::className(), ['model_id' => 'id']);
    }

    public function getFullTitle()
    {
        return ($this->mark != null ? $this->mark->title : '') . ' ' . $this->title;
    }

    public function getMinPrice()
    {
        if (empty($this->tariffs)) {
            return false;
        }
        $min = $this->tariffs[0]->price_for_day;
        foreach ($this->tariffs as $tariff) {
            if ($tariff->price_for_day < $min && $tariff->price_for_day != null) {
                $min = $tariff->price_for_day;
            }
        }
        return $min;
    }

    public function getMaxPrice()
    {
        if (empty($this->tariffs)) {
            return false;
        }
        $max = 0;
        foreach ($this->tariffs as $tariff) {
            if ($tariff->price_for_day > $max && $tariff->price_for_day != null) {
                $max = $tariff->price_for_day;
            }
        }
        if ($max == 0) {
            return false;
        }
        return $max;
    }

    public function upload()
    {
        if ($this->file->saveImageAs(Yii::getAlias('@frontend/web'), '/images/uploads/cars/')) {
            $this->image = $this->file->getRelativeUrl();
            return true;
        }
        return false;
    }

    public function crop()
    {
        if (($this->cropWidth != 0) && ($this->cropHeight != 0)) {
            $siteDirectory = \Yii::getAlias('@frontend/web');
            FileHelper::cropImage($siteDirectory . $this->file->getRelativeUrl(), $this->cropX, $this->cropY, $this->cropWidth, $this->cropHeight, $this->cropWidth, $this->cropHeight);
        }
    }
}
