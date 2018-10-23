<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserve_child".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $date_from
 * @property integer $date_to
 * @property integer $reserve_id
 * @property integer $status
 * @property integer $invoice_id
 * @property integer $service_id
 *
 * @property Reserve $reserve
 * @property AdditionalService $service
 * @property Invoice $invoice
 */
class ReserveChild extends \yii\db\ActiveRecord
{
    const TYPE_PROLONGATION = 1;
    const TYPE_ADDITIONAL_SERVICE_FOR_TIME = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve_child';
    }

    public static function getTypeArray()
    {
        return [
            self::TYPE_PROLONGATION => 'Продление(с прежними настройками)',
            self::TYPE_ADDITIONAL_SERVICE_FOR_TIME => 'Добавление услуг в текущий заказ',
        ];
    }

    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_DELETED => 'Удалено',
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
    public function getService()
    {
        return $this->hasOne(AdditionalService::class, ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }
}
