<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserve_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property integer $reserve_id
 * @property integer $type_id
 */
class ReserveFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve_file';
    }
}
