<?php

namespace common\models;

/**
 * This is the model class for table "tariff".
 *
 * @property integer $id
 * @property string $time
 * @property double $price_for_day
 * @property integer $model_id
 * @property integer $minimal_days
 */
class Tariff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tariff';
    }
}
