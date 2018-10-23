<?php
/**
 * Created at 31.10.2017 17:39
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace frontend\models;


class Invoice extends \common\models\Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['paid_at', 'counter', 'create_date'], 'integer'],
            [['sberbank_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'paid_at' => 'Paid At',
            'sberbank_id' => 'Sberbank ID',
            'counter' => 'Counter',
            'create_date' => 'Create Date',
        ];
    }
}