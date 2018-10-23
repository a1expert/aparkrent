<?php

namespace backend\models;

/**
 * @property Defect[] $defects
 */
class DefectSize extends \common\models\DefectSize
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::className(), ['size_id' => 'id']);
    }
}
