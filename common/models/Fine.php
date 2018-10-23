<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fine".
 *
 * @property integer $id
 * @property integer $reserve_id
 * @property integer $date
 * @property string $paragraph
 * @property string $resolution_number
 * @property string $image
 * @property integer $invoice_id
 *
 * @property Reserve $reserve
 */
class Fine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fine';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserve()
    {
        return $this->hasOne(Reserve::className(), ['id' => 'reserve_id']);
    }
}
