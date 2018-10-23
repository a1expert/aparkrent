<?php

namespace cabinet\models;

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
            [['mark_id', 'class_id', 'status', 'conditioner', 'sort'], 'integer'],
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
}
