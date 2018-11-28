<?php
/**
 * Created at 12.10.2017 18:46
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "additional_service".
 *
 * @property integer $id
 * @property string $title
 * @property double $price
 * @property integer $type
 * @property string $address
 *
 * @property string $fullTitle
 */
class AdditionalService extends ActiveRecord
{
    const TYPE_DELIVERY = 1;
    const TYPE_WASH = 2;
    const TYPE_RENT = 3;

    const REGION_AIRPORT = 1;
    const REGION_RAILWAY_STATION = 2;
    const REGION_CITY = 3;
    const REGION_NEFTEYUGANSK = 4;
    const REGION_KNATYMANSIYSK = 5;
    const REGION_NIZHNEVARTOVSK = 6;
    const REGION_NOYABRSK = 7;
    const REGION_NOVYURENGOY = 8;

    const SERVICE_FULL_CAR_WASH = 9;
    const SERVICE_VIDEO_RECORDER = 10;
    const SERVICE_NAVIGATOR = 11;
    const SERVICE_BABY_SEAT = 12;
    const SERVICE_EXPRESS_CAR_WASH = 13;

    public static $types =[
        self::TYPE_DELIVERY => 'Транспортировка',
        self::TYPE_WASH => 'Мойка',
        self::TYPE_RENT => 'Доп. оборудование',
    ];

    public static $regions =[
        self::REGION_AIRPORT,
        self::REGION_RAILWAY_STATION,
        self::REGION_CITY,
        self::REGION_NEFTEYUGANSK,
        self::REGION_KNATYMANSIYSK,
        self::REGION_NIZHNEVARTOVSK,
        self::REGION_NOYABRSK,
        self::REGION_NOVYURENGOY,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'additional_service';
    }

    public static function getTypeArray()
    {
        return [
            self::TYPE_DELIVERY => 'Транспортировка',
            self::TYPE_WASH => 'Полная Мойка',
            self::TYPE_RENT => 'Доп. оборудование',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'title', 'type'], 'required'],
            [['price'], 'number'],
            [['type'], 'integer'],
            [['title', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'price' => 'Цена',
            'type' => 'Тип',
            'address' => 'Адрес по умолчанию',
        ];
    }

    public function getFullTitle()
    {
        if ($this->type == self::TYPE_DELIVERY) {
            return 'Доставка - ' . $this->title;
        }
        return $this->title;
    }
}