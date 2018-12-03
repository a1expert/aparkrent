<?php

namespace cabinet\models;

use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * @property Reserve[] $reserves
 * @property Fine[] $fines
 * @property Invoice[] $invoices
 */
class Client extends \common\models\Client
{
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
            [['bonus_balance'], 'number'],
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
            'bonus_balance' => 'Бонусный баланс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['client_id' => 'id'])->andWhere(['status' => Reserve::STATUS_ACCEPTED])->orderBy('id DESC');
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
        return Fine::find()->where(['reserve_id' => $reserveIds])->orderBy('date DESC')->all();
    }

    public function getActiveReserveCount()
    {
        return count($this->getReservesByStatus(Reserve::LEAD_STATUS_OPEN));
    }

    public function getReservesByStatus($lead_status)
    {
        return $this->getReserves()->andWhere(['status' => Reserve::STATUS_ACCEPTED])->andWhere(['lead_status' => $lead_status])->all();
    }

    public function getInvoices($paid = 0)
    {
        // TODO Пиздец какой-то, явно проще можно
        $invoices = [];
        foreach ($this->reserves as $reserve) {
            if ($reserve->invoice && $reserve->invoice->price != null && ($paid == ($reserve->invoice->paid_at != null))) {
                $invoices[] =  $reserve->invoice;
            }
        }
        $invoicesIds = [];
        foreach ($this->reserves as $reserve) {
            foreach ($reserve->children as $child) {
                if ($child->status == ReserveChild::STATUS_ACTIVE && $child->invoice->price != null && ($paid == ($child->invoice->paid_at != null))) {
                    $invoicesIds[] = $child->invoice->id;
                }
            }
            foreach ($reserve->fines as $fines) {
                if ($fines->invoice->price != null && ($paid == ($fines->invoice->paid_at != null))) {
                    $invoicesIds[] = $fines->invoice->id;
                }
            }
        }
        $invoicesNotForReserve = Invoice::find()->where(['id' => $invoicesIds])->orderBy('create_date DESC')->all();
        foreach ($invoicesNotForReserve as $invoice) {
            if ($fine = Fine::findOne(['invoice_id' => $invoice->id])) {
                $invoices[] = $invoice;
            } elseif ($child = ReserveChild::findOne(['invoice_id' => $invoice->id])) {
                $invoices[] = $invoice;
            }
        }
        return $invoices;
    }
}
