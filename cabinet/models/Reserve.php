<?php

namespace cabinet\models;

use Yii;

/**
 * @property AutoModel $model
 * @property ReserveAdditionalService[] $reserveAdditionalServices
 * @property ReserveFile[] $files
 * @property Car $car
 * @property Invoice $invoice
 * @property ReserveChild[] $children
 * @property Fine $fines
 * @property Client $client
 */
class Reserve extends \common\models\Reserve
{
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = self::STATUS_NEW;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name', 'phone', 'delivery_date', 'return_date'], 'required'],
            [['model_id', 'delivery_date', 'return_date', 'status', 'legal_type', 'car_id', 'source'], 'integer'],
            [['price'], 'number'],
            [['email'], 'email'],
            [['surname', 'name', 'phone', 'email'], 'string', 'max' => 255],
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
            'email' => 'E-mail',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'model_id' => 'Модель',
            'delivery_date' => 'Дата доставки',
            'price' => 'Цена',
            'return_date' => 'Дата возврата',
            'status' => 'Статус',
            'legal_type' => 'Тип клиента',
            'car_id' => 'Автомобиль',
            'source' => 'Источник',
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
        return $this->hasMany(ReserveChild::className(), ['reserve_id' => 'id']);
    }

    public function getFines()
    {
        return $this->hasMany(Fine::class, ['reserve_id' => 'id']);
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
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
        $timeArray = $this->getRentTime();
        $tariff = Tariff::find()->where(['model_id' => $this->model_id])->andWhere(['<=', 'minimal_days', $timeArray['days']])->orderBy('minimal_days DESC')->one();
        if ($tariff) {
            return $tariff->price_for_day * $timeArray['days'];
        }
        return false;
    }

    /**
     * @return float
     */
    public function getAdditionalCost()
    {
        $price = 0;
        foreach ($this->reserveAdditionalServices as $thisAdditionalService) {
            $service = $thisAdditionalService->additionalService;
            if (in_array($service->type, [AdditionalService::TYPE_DELIVERY, AdditionalService::TYPE_WASH])) {
                $price += $service->price;
            }
            if ($service->type == AdditionalService::TYPE_RENT) {
                $price += $service->price * $this->getDaysForAdditional();
            }
        }
        if ($this->deliveryNotInWorkTime) {
            $price += 0;
        }
        if ($this->returnNotInWorkTime) {
            $price += 0;
        }
        $price += $this->getAdditionalHours() * 300;
        return $price;
    }

    public function getRentTimeString()
    {
        $array = $this->getRentTime();
        $text = $array['days'] . ' суток';
        if ($array['hours'] != 0) {
            $text .= ' и ' . Yii::t('app', '{n, plural, one{# час} few{# часа} other{# часа}}', ['n' => $array['hours']]);
        }
        return $text;
    }

    public function getAdditionalHours()
    {
        return $this->getRentTime()['hours'];
    }
}
