<?php

namespace backend\models;

use Yii;

/**
 * @property Reserve $reserve
 * @property ReserveFileType $type
 */
class ReserveFile extends \common\models\ReserveFile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reserve_id', 'type_id'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
            [['reserve_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reserve::className(), 'targetAttribute' => ['reserve_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'path' => 'Path',
            'reserve_id' => 'Reserve ID',
            'type_id' => 'Тип файла',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserve()
    {
        return $this->hasOne(Reserve::className(), ['id' => 'reserve_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ReserveFileType::className(), ['id' => 'type_id']);
    }
}
