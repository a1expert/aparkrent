<?php

namespace frontend\models;

/**
 * @property Reserve $reserve
 */
class ReserveFile extends \common\models\ReserveFile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reserve_id'], 'integer'],
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
            'name' => 'Name',
            'path' => 'Path',
            'reserve_id' => 'Reserve ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserve()
    {
        return $this->hasOne(Reserve::className(), ['id' => 'reserve_id']);
    }
}
