<?php

namespace backend\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use cabinet\models\User;
use Yii;

/**
 * @property Reserve[] $reserves
 * @property ClientFile[] $files
 * @property ClientChange[] $changes
 */
class Client extends \common\models\Client
{
    public $birthday_string;
    public $passport_date_issue_string;
    public $drive_license_issue_date_string;

    public function beforeSave($insert)
    {
        if ($this->birthday_string != '') {
            $this->birthday = Yii::$app->formatter->asTimestamp($this->birthday_string);
        }
        if ($this->passport_date_issue_string != '') {
            $this->passport_date_issue = Yii::$app->formatter->asTimestamp($this->passport_date_issue_string);
        }
        if ($this->drive_license_issue_date_string != '') {
            $this->drive_license_issue_date = Yii::$app->formatter->asTimestamp($this->drive_license_issue_date_string);
        }
        if ($insert) {
            $this->status = self::STATUS_VERIFIED;
            $this->source = self::SOURCE_MANAGER;
        }
        if ($this->status == self::STATUS_VERIFIED) {
            $user = User::findByPhone($this->phone);
            if (!$user) {
                $user = new User();
                $user->phone = $this->phone;
                $user->register();
            }
        }
        if ($this->getOldAttribute('phone') != $this->phone) {
            $user = User::findOne(['phone' => $this->getOldAttribute('phone')]);
            if ($user) {
                $user->phone = $this->phone;
                $user->save();
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['type', 'birthday', 'passport_date_issue', 'drive_license_issue_date', 'status', 'source', 'drive_license_issue_date'], 'integer'],
            [['passport_place_issue', 'registration_place', 'residence_place', 'birthday_string', 'passport_date_issue_string', 'drive_license_issue_date_string', 'name_for_signature'], 'string'],
            [['inn', 'bik', 'account_number', 'correspondent_account', 'kpp'], 'validatorOnlyNumberInString'],
            [['phone'], PhoneInputValidator::class],
            [['inn'], 'string', 'min' => 10, 'max' => 12],
            [['bik'], 'string', 'min' => 9, 'max' => 9],
            [['account_number', 'correspondent_account'], 'string', 'min' => 20, 'max' => 20],
            [['surname', 'name', 'email', 'patronymic', 'passport_series', 'passport_number', 'additional_phone', 'relative_phone', 'drive_license_series', 'drive_license_number', 'company_name', 'ogrn', 'company_residence', 'post_in_company', 'fio_for_paper', 'bank', 'company_phone', 'company_email', 'kpp'], 'string', 'max' => 255],
            [['phone'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип клиента',
            'phone' => 'Телефон',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'email' => 'Email',
            'patronymic' => 'Отчество',
            'birthday' => 'Дата рождения',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
            'passport_date_issue' => 'Дата выдачи паспорта',
            'passport_place_issue' => 'Место выдачи паспорта',
            'registration_place' => 'Адрес регистрации',
            'residence_place' => 'Адрес проживания',
            'additional_phone' => 'Дополнительный телефон',
            'relative_phone' => 'Телефон родственника',
            'drive_license_series' => 'Серия водительского удостоверения',
            'drive_license_number' => 'Номер водительского удостоверения',
            'company_name' => 'Название компани',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'ogrn' => 'ОГРН',
            'company_residence' => 'Адрес компании',
            'post_in_company' => 'Должность',
            'fio_for_paper' => 'ФИО для подписи',
            'account_number' => 'Рассчетный счет',
            'bik' => 'БИК',
            'bank' => 'Банк',
            'correspondent_account' => 'Корреспондентский счет',
            'company_phone' => 'Телефон компании',
            'company_email' => 'Email компании',
            'birthday_string' => 'Дата рождения',
            'passport_date_issue_string' => 'Дата выдачи паспорта',
            'status' => 'Статус',
            'fullName' => 'ФИО клиента',
            'fullNameAndPhone' => 'ФИО и телефон клиента',
            'source' => 'Источник',
            'drive_license_issue_date_string' => 'Дата выдачи водительского удостоверения',
            'drive_license_issue_date' => 'Дата выдачи водительского удостоверения',
            'bonus_balance' => 'Бонусный баланс',
            'name_for_signature' => 'Имя для подписи(родительный падеж)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(ClientFile::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChanges()
    {
        return $this->hasMany(ClientChange::className(), ['client_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFines()
    {
        $reserveIds = [];
        foreach ($this->reserves as $reserve) {
            $reserveIds[] = $reserve->id;
        }
        return Fine::find()->where(['reserve_id' => $reserveIds])->all();
    }

    public function getUser()
    {
        return User::findByPhone($this->phone);
    }
}
