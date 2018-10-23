<?php

namespace common\models;

/**
 * This is the model class for table "reserve_additional_service".
 *
 * @property integer $id
 * @property integer $reserve_id
 * @property integer $additional_service_id
 * @property integer $delivery_type
 * @property string $address
 * @property integer $time
 */
class ReserveAdditionalService extends \yii\db\ActiveRecord
{
    const DELIVERY_TO_CLIENT = 1;
    const DELIVERY_FROM_CLIENT = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve_additional_service';
    }

    public static function getDeliveryTypeArray()
    {
        return [
            self::DELIVERY_TO_CLIENT => 'Доставка авто',
            self::DELIVERY_FROM_CLIENT => 'Возврат авто',
        ];
    }
}