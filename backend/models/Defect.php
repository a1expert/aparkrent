<?php

namespace backend\models;

/**
 * @property DefectDamage $damage
 * @property Car $car
 * @property DefectDegree $degree
 * @property DefectPlace $place
 * @property DefectSize $size
 */
class Defect extends \common\models\Defect
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDamage()
    {
        return $this->hasOne(DefectDamage::className(), ['id' => 'damage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegree()
    {
        return $this->hasOne(DefectDegree::className(), ['id' => 'degree_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(DefectPlace::className(), ['id' => 'place_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(DefectSize::className(), ['id' => 'size_id']);
    }
}
