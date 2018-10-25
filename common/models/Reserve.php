<?php

namespace frontend\models;

use frontend\services\LoyaltyService;
use Yii;

/**
 * @property int $days
 * @property int $daysForAdditional
 * @property float $rentCost
 * @property float $additionalCost
 * @property bool $additionalHours
 *
 * @property AutoModel $model
 * @property ReserveAdditionalService[] $reserveAdditionalServices
 * @property ReserveFile[] $files
 * @property Client $client
 * @property Invoice $invoice
 *
 * @property [] $addServices
 */
class Reserve extends \common\models\Reserve
{
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = self::STATUS_NEW;
            $this->source = self::SOURCE_SITE;
            if ($this->client && $this->client->status == Client::STATUS_DELETED) {
                $this->client->status = Client::STATUS_NOT_VERIFIED;
                $this->client->save(false);
            }
        }
        return parent::beforeSave($insert);
    }

    public function beforeValidate()
    {
        if ($this->return_date - $this->delivery_date < 3600) {
            $this->addError('delivery_date', 'Даты некорректны');
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_date', 'return_date'], 'required'],
            [['model_id', 'delivery_date', 'return_date', 'status', 'client_id', 'source', 'created_at'], 'integer'],
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
            'delivery_date' => 'Дата доставки',
            'price' => 'Цена',
            'return_date' => 'Дата возврата',
            'client_id' => 'Клиент',
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
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
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
     * @return float
     */
    public function getDaysForAdditional()
    {
        return ceil(($this->return_date - $this->delivery_date) / (24 * 3600));
    }

    /**
     * @return bool|mixed
     */
    public function getRentCost()
    {
        $tariff = Tariff::find()->where(['model_id' => $this->model_id])->andWhere(['<=', 'minimal_days', $this->days])->orderBy('minimal_days DESC')->one();
        if (!$tariff) {
            return false;
        }
        return $tariff->price_for_day * $this->days;
    }

    /**
     * @return float
     */
    public function getAdditionalCost()
    {
        if ($this->invoice) {
            return $this->invoice->price - $this->rentCost;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getAdditionalHours()
    {
        $hours = ceil(($this->return_date - $this->delivery_date) / 3600);
        if (($hours > 3) && ($hours % 24) < 4) {
            return $hours % 24;
        } else {
            return 0;
        }
    }

    public function isPayed()
    {
        if ($this->invoice) {
            return $this->invoice->paid_at != null;
        }
        return false;
    }
}
