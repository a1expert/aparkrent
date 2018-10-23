<?php
/**
 * Created at 08.11.2017 17:58
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace cabinet\models;
/**
 * @property Reserve $reserve
 * @property Invoice $invoice
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
            [['type', 'date_from', 'date_to', 'reserve_id', 'status', 'invoice_id'], 'integer'],
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
            'type' => 'Type',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
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