<?php

namespace cabinet\models;

/**
 * @property AutoModel $model
 */
class Tariff extends \common\models\Tariff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_for_day'], 'number'],
            [['model_id', 'minimal_days'], 'integer'],
            [['time'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModel::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'price_for_day' => 'Price For Day',
            'model_id' => 'Model ID',
            'minimal_days' => 'Minimal Days',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModel::className(), ['id' => 'model_id']);
    }
}
