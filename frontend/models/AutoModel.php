<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;

/**
 * @property AutoClass $class
 * @property AutoMark $mark
 * @property Tariff[] $tariffs
 */
class AutoModel extends \common\models\AutoModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['mark_id', 'class_id', 'status', 'conditioner', 'sort', 'visibility', 'transmission', 'climate_control', 'heating', 'count_free', 'count_total', 'code', 'drive_unit'], 'integer'],
            [['title', 'image', 'equipment', 'engine', 'audio'], 'string', 'max' => 255],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoMark::className(), 'targetAttribute' => ['mark_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'mark_id' => 'Mark ID',
            'image' => 'Image',
            'equipment' => 'Equipment',
            'engine' => 'Engine',
            'conditioner' => 'Conditioner',
            'audio' => 'Audio',
            'class_id' => 'Class ID',
            'status' => 'Status',
            'sort' => 'Sort',
            'visibility' => 'Visibility',
            'transmission' => 'Transmission',
            'climate_control' => 'Climate Control',
            'heating' => 'Heating',
            'count_free' => 'Свободно автомобилей',
            'count_total' => 'Всего автомобилей',
            'code' => 'Код автомобиля',
            'drive_unit' => 'Привод(4WD)',
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
        return $this->hasMany(Tariff::className(), ['model_id' => 'id'])->orderBy('minimal_days');
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

    public function isExistence($object)
    {
        return !empty($object) ? 'Есть' : 'Нет';
    }

    public function getTransmissionTitle()
    {
        return ArrayHelper::getValue(self::$transmissions, $this->transmission, '');
    }

    public function getDriveUnit()
    {
        return ArrayHelper::getValue(self::$drive_units, $this->drive_unit, '');
    }

    public function getTransmissionType()
    {
        return $this->transmission == 1 ? 'АТ' : 'МТ';
    }

    public function getCountFree()
    {
        return !empty($this->count_free) ? $this->count_free : '0';
    }

    public function getFreeCars()
    {
        $arr[0] = [
            'status' => '',
            'title' => '',
        ];
        if (isset($this->count_free) && !empty($this->count_total)) {
            for ($i = 0, $arr = []; $i < $this->count_total; $i++) {
                if ($i < $this->count_free) {
                    $arr[$i] =
                        [
                            'status' => 'status free',
                            'title' => 'Автомобиль свободен',
                        ];
                } else {
                    $arr[$i] =
                        [
                            'status' => 'status reserve',
                            'title' => 'Автомобиль занят',
                        ];
                }
            }
        }
        return $arr;
    }
}
