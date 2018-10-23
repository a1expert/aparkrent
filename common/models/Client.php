<?php
/**
 * Created at 12.10.2017 19:00
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property integer $type
 * @property string $phone
 * @property string $surname
 * @property string $name
 * @property string $email
 * @property string $patronymic
 * @property integer $birthday
 * @property string $passport_series
 * @property string $passport_number
 * @property integer $passport_date_issue
 * @property string $passport_place_issue
 * @property string $registration_place
 * @property string $residence_place
 * @property string $additional_phone
 * @property string $relative_phone
 * @property string $drive_license_series
 * @property string $drive_license_number
 * @property integer $drive_license_issue_date
 * @property string $company_name
 * @property string $inn
 * @property string $kpp
 * @property string $ogrn
 * @property string $company_residence
 * @property string $post_in_company
 * @property string $fio_for_paper
 * @property string $account_number
 * @property string $bik
 * @property string $bank
 * @property string $correspondent_account
 * @property string $company_phone
 * @property string $company_email
 * @property integer $status
 * @property integer $source
 * @property float $bonus_balance
 * @property string $name_for_signature
 *
 * @property Reserve[] $reserves
 *
 * @property string $fullName
 * @property string $fullNameAndPhone
 */

class Client extends ActiveRecord
{
    const TYPE_INDIVIDUAL = 1;
    const TYPE_LEGAL = 2;

    const STATUS_NOT_VERIFIED = 0;
    const STATUS_VERIFIED = 1;
    const STATUS_DELETED = 2;
    const STATUS_DENIED = 3;

    const SOURCE_SITE = 1;
    const SOURCE_MANAGER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @param $attribute
     */
    public function validatorOnlyNumberInString($attribute)
    {
        if (preg_match('/[^0-9]/', $this->getAttribute($attribute)) > 0) {
            $this->addError( $attribute, 'Допускаются только числовые символы');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::class, ['client_id' => 'id']);
    }


    /**
     * @return string
     */
    public function getFullName()
    {
        if ($this->type == self::TYPE_LEGAL) {
            return $this->company_name;
        }
        return trim($this->surname . ' ' . $this->name . ' ' . $this->patronymic);
    }

    /**
     * @return string
     */
    public function getFullNameAndPhone()
    {
        return $this->fullName . ' (' . $this->phone . ')';
    }

    public function getNameAndInitials()
    {
        $first = 1;
        $text = '';
        if ($this->surname != '') {
            $text .= $this->surname;
            $first = 0;
        }
        if ($this->name != '') {
            if ($first) {
                $text .= $this->name;
            } else {
                $text .= ' ' . mb_substr($this->name, 0, 1) . '. ';
            }
        }
        if ($this->patronymic != '') {
            $text .= ' ' . mb_substr($this->patronymic, 0, 1) . '.';
        }
        return $text;
    }

    /**
     * @return array
     */
    public static function getTypeArray()
    {
        return [
            self::TYPE_INDIVIDUAL => 'Физ. лицо',
            self::TYPE_LEGAL => 'Юр. лицо',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_NOT_VERIFIED => 'Неподтврежденный',
            self::STATUS_VERIFIED => 'Подтврежденный',
            self::STATUS_DENIED => 'Отказано',
        ];
    }

    public static function getSourceArray()
    {
        return [
            self::SOURCE_SITE => 'С сайта',
            self::SOURCE_MANAGER => 'Добавил менеджер',
        ];
    }
}