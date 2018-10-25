<?php
/**
 * Created at 12.10.2017 18:39
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "reserve".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $delivery_date
 * @property integer $return_date
 * @property integer $status
 * @property integer $car_id
 * @property integer $client_id
 * @property integer $source
 * @property integer $lead_status
 * @property string $comment
 * @property integer $invoice_id
 * @property integer $created_at
 *
 * @property Client $client
 * @property Invoice $invoice
 * @property ReserveChild[] $children
 *
 * @property bool $deliveryNotInWorkTime
 * @property bool $returnNotInWorkTime
 * @property array $rentTime
 */
class Reserve extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_DELETED = 4;

    const SOURCE_SITE = 1;
    const SOURCE_MANAGER = 2;

    const LEAD_STATUS_OPEN = 1;
    const LEAD_STATUS_CLOSE = 2;

    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_NEW => 'Новая заявка',
            self::STATUS_ACCEPTED => 'Одобрено',
            self::STATUS_REJECTED => 'Отказано',
        ];
    }

    public static function getSourceArray()
    {
        return [
            self::SOURCE_SITE => 'С сайта',
            self::SOURCE_MANAGER => 'Добавил менеджер',
        ];
    }

    public static function getLeadStatusArray()
    {
        return [
            self::LEAD_STATUS_OPEN => 'Открыта',
            self::LEAD_STATUS_CLOSE => 'Закрыта',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(ReserveChild::class, ['reserve_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function getDeliveryNotInWorkTime()
    {
        $hour = \Yii::$app->formatter->asTime($this->delivery_date, 'H');
        if (($hour > 20) || ($hour < 8)) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getReturnNotInWorkTime()
    {
        $hour = \Yii::$app->formatter->asTime($this->return_date, 'H');
        if (($hour > 20) || ($hour < 8)) {
            return true;
        }
        return false;
    }

    public function getRentTime()
    {
        $hours = ceil(($this->return_date - $this->delivery_date) / 3600);
        $days = (int)($hours / 24);
        if ($hours - ($days * 24) > 3) {
            $days++;
            $hours = 0;
        } else {
            $hours = ceil($hours - $days * 24);
        }
        return [
            'days' => $days,
            'hours' => $hours,
        ];
    }

    public function getDaysForAdditional()
    {
        $timeArray = $this->getRentTime();
        return $timeArray['days'] + ($timeArray['hours'] == 0 ? 0 : 1);
    }

    public function getRentDate()
    {
        $endDate = $this->return_date;
        $prolongation = false;
        foreach ($this->children as $child) {
            if ($child->type == ReserveChild::TYPE_PROLONGATION) {
                if ($child->date_to > $endDate) {
                    $prolongation = true;
                    $endDate = $child->date_to;
                }
            }
        }
        return \Yii::$app->formatter->asDatetime($this->delivery_date, 'd-M-Y') . ' - ' . \Yii::$app->formatter->asDatetime($endDate, 'd-M-Y') . ($prolongation ? ' (продлено)' : '');
    }
}