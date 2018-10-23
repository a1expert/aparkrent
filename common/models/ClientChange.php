<?php

namespace common\models;

/**
 * This is the model class for table "client_change".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $attribute
 * @property string $old_value
 * @property string $new_value
 */
class ClientChange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_change';
    }
}
