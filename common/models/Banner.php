<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.12.2018
 * Time: 13:52
 */

namespace common\models;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $title_1
 * @property string $title_2
 * @property string $image
 */
class Banner extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_1' => 'Заголовок 1',
            'title_2' => 'Заголовок 2',
            'image' => 'Изображение',
        ];
    }
}