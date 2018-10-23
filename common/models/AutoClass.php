<?php
/**
 * Created at 12.10.2017 18:51
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;
/**
 * This is the model class for table "auto_class".
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 *
 * @property AutoModel[] $autoModels
 */

use yii\db\ActiveRecord;

class AutoClass extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Класс',
            'sort' => 'Сортировка',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModel::className(), ['class_id' => 'id']);
    }

}