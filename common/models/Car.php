<?php
/**
 * Created at 12.10.2017 18:59
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "car".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $number
 * @property string $vin
 * @property string $registration_certificate
 * @property integer $year_of_issue
 *
 * @property AutoModel $model
 * @property Reserve[] $reserves
 * @property Defect $defects[]
 */

class Car extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'year_of_issue'], 'integer'],
            [['number', 'vin', 'registration_certificate'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModel::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Модель',
            'number' => 'Номер автомобиля',
            'vin' => 'VIN',
            'registration_certificate' => 'Свидетельство о ТС',
            'year_of_issue' => 'Год выпуска',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModel::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['car_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::class, ['car_id' => 'id']);
    }
}