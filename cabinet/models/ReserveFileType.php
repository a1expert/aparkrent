<?php

namespace cabinet\models;

/**
 * @property ReserveFile[] $reserveFiles
 */
class ReserveFileType extends \common\models\ReserveFileType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['legal_type'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legal_type' => 'Legal Type',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserveFiles()
    {
        return $this->hasMany(ReserveFile::className(), ['type_id' => 'id']);
    }
}
