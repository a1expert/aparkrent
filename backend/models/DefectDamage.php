<?php

namespace backend\models;

/**
 * @property Defect[] $defects
 */
class DefectDamage extends \common\models\DefectDamage
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::className(), ['damage_id' => 'id']);
    }
}
