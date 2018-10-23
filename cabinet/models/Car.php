<?php

namespace cabinet\models;

/**
 * @property AutoModel $model
 * @property Reserve[] $reserves
 */
class Car extends \common\models\Car
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModel::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['car_id' => 'id']);
    }
}
