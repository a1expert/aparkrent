<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserve_file_type".
 *
 * @property integer $id
 * @property integer $legal_type
 * @property string $title
 * @property string $generate_type
 * @property integer $to_client
 */
class ReserveFileType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve_file_type';
    }
}
