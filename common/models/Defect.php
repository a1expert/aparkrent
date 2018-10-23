<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "defect".
 *
 * @property integer $id
 * @property integer $car_id
 * @property integer $place_id
 * @property integer $size_id
 * @property integer $degree_id
 * @property integer $damage_id
 *
 * @property DefectDamage $damage
 * @property Car $car
 * @property DefectDegree $degree
 * @property DefectPlace $place
 * @property DefectSize $size
 */
class Defect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'defect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_id', 'place_id', 'size_id', 'degree_id', 'damage_id'], 'integer'],
            [['damage_id'], 'exist', 'skipOnError' => true, 'targetClass' => DefectDamage::className(), 'targetAttribute' => ['damage_id' => 'id']],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => Car::className(), 'targetAttribute' => ['car_id' => 'id']],
            [['degree_id'], 'exist', 'skipOnError' => true, 'targetClass' => DefectDegree::className(), 'targetAttribute' => ['degree_id' => 'id']],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => DefectPlace::className(), 'targetAttribute' => ['place_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => DefectSize::className(), 'targetAttribute' => ['size_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Автомобиль',
            'place_id' => 'Место',
            'size_id' => 'Размер',
            'degree_id' => 'Степень',
            'damage_id' => 'Ущерб',
        ];
    }

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
