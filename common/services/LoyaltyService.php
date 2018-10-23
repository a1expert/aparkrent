<?php

namespace common\services;

use common\models\Invoice;

/**
 * Created at 30.10.2017 15:23
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

class LoyaltyService
{
    const LOYALTY_STATUS_PLATINUM  = 'platinum';
    const LOYALTY_STATUS_GOLD  = 'gold';
    const LOYALTY_STATUS_SILVER  = 'silver';

    private $client;
    private $paidAmount;

    public function __construct($client, $current_invoice_id = null)
    {
        $this->client = $client;
        $this->paidAmount = 0;
        foreach ($this->client->reserves as $reserve) {
            if ($reserve->invoice && $reserve->invoice->paid_at && $reserve->invoice->id != $current_invoice_id) {
                $this->paidAmount += $reserve->invoice->getPriceForPayment();
            }
            foreach ($reserve->children as $child) {
                if ($child->invoice && $child->invoice->paid_at && $child->invoice->id != $current_invoice_id) {
                    $this->paidAmount += $child->invoice->getPriceForPayment();
                }
            }
        }
    }

    public function getLoyaltyStatus()
    {
        if ($this->paidAmount < 100000) {
            return self::LOYALTY_STATUS_SILVER;
        }
        if ($this->paidAmount < 300000) {
            return self::LOYALTY_STATUS_GOLD;
        }
        return self::LOYALTY_STATUS_PLATINUM;
    }

    public function getProgressToNextLoyaltyStatus()
    {
        if ($this->paidAmount < 100000) {
            return $this->paidAmount / 100000 * 100;
        }
        if ($this->paidAmount < 300000) {
            return $this->paidAmount / 300000 * 100;
        }
        return 100;
    }

    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    public function getLoyaltyStatusName()
    {
        switch ($this->getLoyaltyStatus()) {
            case self::LOYALTY_STATUS_SILVER:
                return 'СЕРЕБРО';
            case self::LOYALTY_STATUS_GOLD:
                return 'ЗОЛОТО';
            case self::LOYALTY_STATUS_PLATINUM:
                return 'ПЛАТИНА';
        }
        return '';
    }

    public function hasNextLoyaltyStatus()
    {
        if ($this->getLoyaltyStatus() != self::LOYALTY_STATUS_PLATINUM) {
            return true;
        }
        return false;
    }

    public function getNextLoyaltyStatusName()
    {
        switch ($this->getLoyaltyStatus()) {
            case self::LOYALTY_STATUS_SILVER:
                return 'ЗОЛОТО';
            case self::LOYALTY_STATUS_GOLD:
                return 'ПЛАТИНА';
        }
        return null;
    }

    public function getDiscountRate()
    {
        switch ($this->getLoyaltyStatus()) {
            case self::LOYALTY_STATUS_SILVER:
                return 3;
            case self::LOYALTY_STATUS_GOLD:
                return 4;
            case self::LOYALTY_STATUS_PLATINUM:
                return 5;
        }
        return 0;
    }

    public function getClientBonuses()
    {
        return (float)$this->client->bonus_balance;
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    public function addBonusesToClient($invoice)
    {
        if ($invoice && $invoice->getPriceForPayment() != null && $invoice->paid_at == null) {
            $this->client->bonus_balance += $invoice->getPriceForPayment() * $this->getDiscountRate() / 100;
            $invoice->paid_at = \Yii::$app->formatter->asTimestamp('NOW');
            return true;
        }
        $invoice->paid_at = \Yii::$app->formatter->asTimestamp('NOW');
        return false;
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    public function getBonusesFromClient($invoice)
    {
        if ($invoice && $invoice->getPriceForPayment() != null && $invoice->paid_at != null) {
            $this->client->bonus_balance -= $invoice->getPriceForPayment() * $this->getDiscountRate() / 100;
            $invoice->paid_at = null;
            return true;
        }
        $invoice->paid_at = \Yii::$app->formatter->asTimestamp('NOW');
        return false;
    }
}