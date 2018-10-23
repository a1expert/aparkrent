<?php
/**
 * Created at 12.10.2017 18:53
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;

/**
 * This is the model class for table "auto_mark".
 *
 * @property integer $id
 * @property string $title
 * @property string $logo
 * @property string $color
 */

use yii\db\ActiveRecord;

class AutoMark extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_mark';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'logo', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Марка',
            'logo' => 'Лого',
            'color' => 'Цвет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModel::className(), ['mark_id' => 'id']);
    }
}