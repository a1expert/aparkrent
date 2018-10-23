<?php

namespace common\models;

/**
 * This is the model class for table "client_file".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $path
 * @property string $name
 */
class ClientFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_file';
    }
}
