<?php

namespace backend\models;

use Yii;

/**
 * @property AdditionalService $additionalService
 * @property Reserve $reserve
 */
class ReserveAdditionalService extends \common\models\ReserveAdditionalService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reserve_id', 'additional_service_id', 'delivery_type', 'time'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['additional_service_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdditionalService::className(), 'targetAttribute' => ['additional_service_id' => 'id']],
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
            'reserve_id' => 'Reserve ID',
            'additional_service_id' => 'Additional Service ID',
            'address' => 'Адрес',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalService()
    {
        return $this->hasOne(AdditionalService::className(), ['id' => 'additional_service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserve()
    {
        return $this->hasOne(Reserve::className(), ['id' => 'reserve_id']);
    }
}