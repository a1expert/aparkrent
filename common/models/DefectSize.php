<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "defect_size".
 *
 * @property integer $id
 * @property integer $code
 * @property string $title
 *
 * @property Defect[] $defects
 */
class DefectSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'defect_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::className(), ['size_id' => 'id']);
    }
}
