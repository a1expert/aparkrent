<?php

namespace common\models;

use common\services\LoyaltyService;
use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property double $price
 * @property integer $paid_at
 * @property string $sberbank_id
 * @property integer $counter
 * @property integer $create_date
 * @property double $bonuses
 *
 * @property Reserve $reserve
 * @property ReserveChild $child
 * @property Fine $fine
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_date = Yii::$app->formatter->asTimestamp('NOW');
        }
        return parent::beforeSave($insert);
    }

    public function getReserve()
    {
        return $this->hasOne(Reserve::class, ['invoice_id' => 'id']);
    }

    public function getChild()
    {
        return $this->hasOne(ReserveChild::class, ['invoice_id' => 'id']);
    }

    public function getFine()
    {
        return $this->hasOne(Fine::class, ['invoice_id' => 'id']);
    }

    public function isFine()
    {
        return $this->fine !== null;
    }

    public function isChild()
    {
        return $this->child !== null;
    }

    public function isReserve()
    {
        return $this->reserve !== null;
    }

    public function getPaymentText()
    {
        if ($this->isFine()) {
            return 'Оплата штрафа с заказа №' . $this->fine->reserve->id;
        }
        if ($this->isChild()) {
            if ($this->child->type == ReserveChild::TYPE_PROLONGATION) {
                return 'Оплата продления заказа №' . $this->child->reserve->id;
            }
            if ($this->child->type == ReserveChild::TYPE_ADDITIONAL_SERVICE_FOR_TIME) {
                if ($this->child->service) {
                    return 'Оплата доп услуги "'.$this->child->service->getFullTitle().'" с заказа №' . $this->child->reserve->id;
                }
            }
            return 'Оплата доп счета с заказа №' . $this->child->reserve->id;
        }
        if ($this->isReserve()) {
            return 'Оплата заказа №' . $this->reserve->id;
        }
        return null;
    }

    public function setPayedFlag()
    {
        if ($this->isReserve() || $this->isChild()) {
            if ($this->isReserve()) {
                $client = $this->reserve->client;
            } else {
                $client = $this->child->reserve->client;
            }
            $loyaltyService = new LoyaltyService($client, $this->id);
            $loyaltyService->addBonusesToClient($this);
            $client->save(false);
        } else {
            $this->paid_at = Yii::$app->formatter->asTimestamp('NOW');
        }
        return $this->save(false);
    }

    public function unsetPayedFlag()
    {
        if ($this->isReserve() || $this->isChild()) {
            if ($this->isReserve()) {
                $client = $this->reserve->client;
            } else {
                $client = $this->child->reserve->client;
            }
            $loyaltyService = new LoyaltyService($client, $this->id);
            $loyaltyService->getBonusesFromClient($this);
            $client->save(false);
        } else {
            $this->paid_at = null;
        }
        return $this->save(false);
    }

    public function getPriceForPayment()
    {
        return (double)$this->price - (double)$this->bonuses;
    }
}
