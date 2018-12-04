<?php
/**
 * Created at 12.10.2017 18:57
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auto_model".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $mark_id
 * @property string $image
 * @property string $equipment
 * @property string $engine
 * @property integer $conditioner
 * @property string $audio
 * @property integer $class_id
 * @property integer $status
 * @property integer $sort
 * @property integer $visibility
 * @property integer $transmission
 * @property integer $climate_control
 * @property integer $heating
 * @property integer $count_free
 * @property integer $count_total
 * @property integer $code
 * @property integer $drive_unit
 */

class AutoModel extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const VISIBILITY_HIDDEN = 0;
    const VISIBILITY_VISIBLE = 1;

    const TRANSMISSION_A = 1;
    const TRANSMISSION_M = 2;

    public static $visibilities = [
        self::VISIBILITY_HIDDEN => 'нет',
        self::VISIBILITY_VISIBLE => 'да',
    ];

    public static $statuses = [
        self::STATUS_ACTIVE => 'Доступно',
        self::STATUS_INACTIVE => 'Недоступно',
    ];

    public static $transmissions = [
        self::TRANSMISSION_A => 'Автоматическая коробка передач',
        self::TRANSMISSION_M => 'Механическая коробка передач',
    ];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Модель',
            'description' => 'Описание',
            'mark_id' => 'Марка',
            'image' => 'Изображение',
            'equipment' => 'Комплектация',
            'engine' => 'Двигатель',
            'conditioner' => 'Кондиционер',
            'audio' => 'Аудио',
            'class_id' => 'Класс',
            'file' => 'Изображение',
            'status' => 'Статус',
            'sort' => 'Сортировка',
            'visibility' => 'Отображать на сайте',
            'transmission' => 'Коробка передач',
            'climate_control' => 'Климат контроль',
            'heating' => 'Подогрев сидений и руля',
            'count_free' => 'Свободно автомобилей',
            'count_total' => 'Всего автомобилей',
            'code' => 'Код автомобиля',
            'drive_unit' => 'Привод(4WD)',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_model';
    }
}