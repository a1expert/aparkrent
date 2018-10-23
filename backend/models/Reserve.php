<?php

namespace backend\models;

use cabinet\models\User;

/**
 * @property AutoModel $model
 * @property ReserveAdditionalService[] $reserveAdditionalServices
 * @property ReserveFile[] $files
 * @property Client $client
 * @property Fine[] $fines
 * @property Car $car
 * @property Invoice $invoice
 * @property ReserveChild[] $children
 *
 * @property [] $addServices
 * @property [] $statusArray
 * @property [] $legalTypeArray
 * @property string $rentDate
 * @property double $price
 * @property integer $paidAt
 */
class Reserve extends \common\models\Reserve
{
    public $addServices;
    public $delivery;
    public $hour;
    public $minute;

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->status == null) {
                $this->status = self::STATUS_NEW;
            }
            $this->source = self::SOURCE_MANAGER;
        }
        if ($this->status == self::STATUS_ACCEPTED) {
            if ($this->lead_status == null) {
                $this->lead_status = self::LEAD_STATUS_OPEN;
            }
            $this->client->status = Client::STATUS_VERIFIED;
            $this->client->save();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'delivery_date', 'return_date', 'status', 'client_id', 'car_id', 'source', 'lead_status', 'invoice_id'], 'integer'],
            [['comment'], 'string'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModel::className(), 'targetAttribute' => ['model_id' => 'id']],
            [['addServices',  'delivery', 'hour', 'minute'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'model_id' => 'Модель',
            'delivery_date' => 'Дата получения',
            'return_date' => 'Дата возврата',
            'status' => 'Статус',
            'car_id' => 'Автомобиль',
            'client_id' => 'Клиент',
            'source' => 'Источник',
            'lead_status' => 'Статус сделки',
            'rentDate' => 'Период аренды',
            'comment' => 'Примечание',
            'price' => 'Цена',
            'paidAt' => 'Оплата',
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
    public function getReserveAdditionalServices()
    {
        return $this->hasMany(ReserveAdditionalService::className(), ['reserve_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(ReserveFile::className(), ['reserve_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFines()
    {
        return $this->hasMany(Fine::className(), ['reserve_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(ReserveChild::className(), ['reserve_id' => 'id'])->andWhere(['status' => ReserveChild::STATUS_ACTIVE]);
    }

    public function getPrice()
    {
        if ($this->invoice) {
            return $this->invoice->price;
        }
        return null;
    }

    public function getPaidAt()
    {
        if ($this->invoice) {
            return $this->invoice->paid_at;
        }
        return null;
    }

    public function createInvoice()
    {
        if ($this->invoice == null) {
            $invoice = new Invoice();
            $invoice->save(false);
            $this->invoice_id = $invoice->id;
            $this->save(false);
            $this->refresh();
        }
    }

    /**
     *
     */
    public function setAdditionalServices()
    {
        if (!empty($this->addServices)) {
            foreach ($this->addServices as $key => $value) {
                if ($value == 1) {
                    $service = new ReserveAdditionalService();
                    $service->reserve_id = $this->id;
                    $service->additional_service_id = $key;
                    $service->insert();
                }
            }
        }
        foreach ($this->delivery as $key => $value) {
            $service = new ReserveAdditionalService();
            $service->reserve_id = $this->id;
            $service->additional_service_id = $value->service_id;
            $service->delivery_type = $value->delivery_type;
            $service->insert();
        }
    }

    /**
     * @return float|int
     */
    public function getDays()
    {
        $hours = ($this->return_date - $this->delivery_date) / 3600;
        if ($hours <= 27) {
            return 1;
        }
        if ($hours % 24 <= 3) {
            return floor($hours / 24);
        }
        return ceil($hours / 24);
    }

    /**
     * @return bool|mixed
     */
    public function getRentCost()
    {
        $tariff = Tariff::find()->where(['model_id' => $this->model_id])->andWhere(['<=', 'minimal_days', $this->getDays()])->orderBy('minimal_days DESC')->one();
        if (!$tariff) {
            return false;
        }
        return $tariff->price_for_day * $this->getDays();
    }
}
