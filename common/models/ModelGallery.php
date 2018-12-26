<?php

namespace common\models;


/**
 * This is the model class for table "model_gallery".
 *
 * @property int $id
 * @property integer $model_id
 * @property string $photo
 *
 * @property AutoModel $model
 */
class ModelGallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id'], 'integer'],
            [['photo'], 'string'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModel::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModel::className(), ['id' => 'model_id']);
    }
}
