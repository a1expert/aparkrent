<?php

namespace frontend\models;

/**
 * @property AutoModel[] $autoModels
 */
class AutoClass extends \common\models\AutoClass
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModel::className(), ['class_id' => 'id']);
    }
}
