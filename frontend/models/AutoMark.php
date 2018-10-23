<?php

namespace frontend\models;

/**
 * @property AutoModel[] $autoModels
 */
class AutoMark extends \common\models\AutoMark
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModel::className(), ['mark_id' => 'id']);
    }

    public function getActiveModels()
    {
        return self::getAutoModels()->andWhere(['status' => AutoModel::STATUS_ACTIVE]);
    }
}
