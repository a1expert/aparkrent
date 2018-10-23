<?php

namespace backend\models;

/**
 * @property Defect[] $defects
 */
class DefectPlace extends \common\models\DefectPlace
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::className(), ['place_id' => 'id']);
    }
}
