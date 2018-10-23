<?php

namespace backend\models;

/**
 * @property Defect[] $defects
 */
class DefectDegree extends \common\models\DefectDegree
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::className(), ['degree_id' => 'id']);
    }
}
