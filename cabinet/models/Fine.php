<?php

namespace cabinet\models;

/**
 * @property Reserve $reserve
 */
class Fine extends \common\models\Fine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reserve_id', 'date', 'invoice_id'], 'integer'],
            [['paragraph', 'resolution_number'], 'string', 'max' => 255],
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
            'date' => 'Date',
            'paragraph' => 'Paragraph',
            'resolution_number' => 'Resolution Number',
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
}
