<?php

namespace frontend\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use Yii;

/**
 * @property Reserve[] $reserves
 */
class Client extends \common\models\Client
{
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = self::STATUS_NOT_VERIFIED;
            $this->source = self::SOURCE_SITE;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'birthday', 'passport_date_issue', 'drive_license_issue_date', 'status', 'source'], 'integer'],
            [['passport_place_issue', 'registration_place', 'residence_place'], 'string'],
            [['surname', 'name', 'email', 'patronymic', 'passport_series', 'passport_number', 'additional_phone', 'relative_phone', 'drive_license_series', 'drive_license_number', 'company_name', 'inn', 'kpp', 'ogrn', 'company_residence', 'post_in_company', 'fio_for_paper', 'account_number', 'bik', 'bank', 'correspondent_account', 'company_phone', 'company_email'], 'string', 'max' => 255],
            [['phone'], 'unique'],
            [['phone'], PhoneInputValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'phone' => 'Phone',
            'surname' => 'Surname',
            'name' => 'Name',
            'email' => 'Email',
            'patronymic' => 'Patronymic',
            'birthday' => 'Birthday',
            'passport_series' => 'Passport Series',
            'passport_number' => 'Passport Number',
            'passport_date_issue' => 'Passport Date Issue',
            'passport_place_issue' => 'Passport Place Issue',
            'registration_place' => 'Registration Place',
            'residence_place' => 'Residence Place',
            'additional_phone' => 'Additional Phone',
            'relative_phone' => 'Relative Phone',
            'drive_license_series' => 'Drive License Series',
            'drive_license_number' => 'Drive License Number',
            'company_name' => 'Company Name',
            'inn' => 'Inn',
            'kpp' => 'Kpp',
            'ogrn' => 'Ogrn',
            'company_residence' => 'Company Residence',
            'post_in_company' => 'Post In Company',
            'fio_for_paper' => 'Fio For Paper',
            'account_number' => 'Account Number',
            'bik' => 'Bik',
            'bank' => 'Bank',
            'correspondent_account' => 'Correspondent Account',
            'company_phone' => 'Company Phone',
            'company_email' => 'Company Email',
            'status' => 'Статус',
            'source' => 'Источник',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['client_id' => 'id']);
    }
}
