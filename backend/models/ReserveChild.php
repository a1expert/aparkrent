<?php
/**
 * Created at 07.11.2017 16:26
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\models;
/**
 * @property Reserve $reserve
 * @property Invoice $invoice
 * @property AdditionalService $service
 */

class ReserveChild extends \common\models\ReserveChild
{
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = self::STATUS_ACTIVE;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'date_from', 'date_to', 'reserve_id', 'status', 'invoice_id', 'service_id'], 'integer'],
            [['reserve_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reserve::class, 'targetAttribute' => ['reserve_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdditionalService::class, 'targetAttribute' => ['service_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::class, 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'reserve_id' => 'Reserve ID',
            'service_id' => 'Услуга',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserve()
    {
        return $this->hasOne(Reserve::class, ['id' => 'reserve_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(AdditionalService::class, ['id' => 'service_id']);
    }

    public function createInvoice()
    {
        if ($this->invoice == null) {
            $invoice = new Invoice();
            $invoice->save(false);
            $this->invoice_id = $invoice->id;
            $this->save(false);
        }
        $this->refresh();
    }
}