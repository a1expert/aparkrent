<?php
/**
 * Created at 11.10.2017 18:26
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
namespace backend\services;

use backend\models\AdditionalService;
use backend\models\ReserveChild;
use backend\models\Tariff;
use Yii;


class CountReservePriceService
{
    /**
     * @param \backend\models\Reserve $reserve
     * @return array
     */
    public static function countPrice($reserve)
    {
        if (!$reserve->invoice) {
            $reserve->createInvoice();
        }
        if ($reserve->invoice->paid_at != null) {
            return [
                'status' => 'fail',
                'message' => 'Заказ оплачен',
            ];
        }
        if ($reserve->delivery_date == 0 || $reserve->return_date == 0) {
            $reserve->invoice->price = 0;
            $reserve->invoice->save();
            return [
                'status' => 'fail',
                'message' => 'Даты не заданы',
            ];
        }
        $minutes = ($reserve->return_date - $reserve->delivery_date) / 60;
        if ($minutes <= 0) {
            $reserve->invoice->price = 0;
            $reserve->invoice->save();
            return [
                'status' => 'fail',
                'message' => 'Дата возврата раньше даты отправки',
            ];
        }
        $hours = ceil(($reserve->return_date - $reserve->delivery_date) / 3600);
        $days = (int)(($reserve->return_date - $reserve->delivery_date) / (24 * 3600));
        $daysForAdditional = ceil($hours/24);
        $price = 0;
        if (($hours < 24) || (ceil($hours % 24)) > 3) {
            $days++;
        } else {
            $price += ceil($hours % 24) * 300;
        }
        $tariff = Tariff::find()->where(['model_id' => $reserve->model_id])->andWhere(['<=', 'minimal_days', $days])->orderBy('minimal_days DESC')->one();
        if (!$tariff) {
            $reserve->invoice->price = 0;
            $reserve->invoice->save();
            return [
                'status' => 'fail',
                'message' => 'Невозможно подобрать тариф',
            ];
        }
        $price += $tariff->price_for_day * $days;
        foreach ($reserve->reserveAdditionalServices as $id => $addService) {
            $service = $addService->additionalService;
            if ($service->type == AdditionalService::TYPE_WASH) {
                $price += $service->price;
            }
            if ($service->type == AdditionalService::TYPE_DELIVERY) {
                $price += $service->price;
            }
            if ($service->type == AdditionalService::TYPE_RENT) {
                $price += ($daysForAdditional * $service->price);
            }
        }

        Yii::$app->formatter->asTime($reserve->delivery_date, 'H');
        if (!empty($reserve->reserveAdditionalServices[0]->time)) {
            if (Yii::$app->formatter->asTime($reserve->reserveAdditionalServices[0]->time, 'H') >= 20 || Yii::$app->formatter->asTime($reserve->reserveAdditionalServices[0]->time, 'H') < 8) {
                $price += 500;
            }
        }
        if (Yii::$app->formatter->asTime($reserve->return_date, 'H') >= 20 || Yii::$app->formatter->asTime($reserve->return_date, 'H') < 8) {
            $price += 0;
        }
        $reserve->invoice->price = $price;
        $reserve->invoice->save();
        return [
            'status' => 'ok',
            'price' => $price,
        ];
    }

    /**
     * @param ReserveChild $child
     * @return array
     */
    public static function countPriceForChild($child)
    {
        if ($child->type == ReserveChild::TYPE_PROLONGATION) {
            return self::countProlongation($child);
        }
        if ($child->type == ReserveChild::TYPE_ADDITIONAL_SERVICE_FOR_TIME) {
            if (in_array($child->service->type, [AdditionalService::TYPE_WASH, AdditionalService::TYPE_DELIVERY])) {
                $child->invoice->price = $child->service->price;
                $child->invoice->save(false);
                return [
                    'status' => 'ok',
                    'price' => $child->invoice->price,
                ];
            } else {
                $seconds = $child->date_to - $child->date_from;
                if ($seconds <= 0) {
                    return [
                        'status' => 'fail',
                        'message' => 'Даты некорректны',
                    ];
                }
                $days = ceil($seconds / (60 * 60 *24));
                $child->invoice->price = $child->service->price * $days;
                $child->invoice->save(false);
                return [
                    'status' => 'ok',
                    'price' => $child->invoice->price,
                ];
            }
        }
    }

    public static function countProlongation($child)
    {
        $reserve = $child->reserve;
        $reserve->return_date = $child->date_to;
        if ($reserve->delivery_date == 0 || $reserve->return_date == 0) {
            $child->invoice->price = 0;
            $child->invoice->save();
            return [
                'status' => 'fail',
                'message' => 'Даты не заданы',
            ];
        }
        $minutes = ($reserve->return_date - $reserve->delivery_date) / 60;
        if ($minutes <= 0) {
            $child->invoice->price = 0;
            $child->invoice->save();
            return [
                'status' => 'fail',
                'message' => 'Дата возврата раньше даты отправки',
            ];
        }
        $hours = ceil(($reserve->return_date - $reserve->delivery_date) / 3600);
        $days = (int)(($reserve->return_date - $reserve->delivery_date) / (24 * 3600));
        $daysForAdditional = ceil($hours / 24);
        $price = 0;
        if (($hours < 24) || (ceil($hours % 24)) > 3) {
            $days++;
        } else {
            $price += ceil($hours % 24) * 300;
        }
        $tariff = Tariff::find()->where(['model_id' => $reserve->model_id])->andWhere(['<=', 'minimal_days', $days])->orderBy('minimal_days DESC')->one();
        if (!$tariff) {
            $child->invoice->price = 0;
            $child->invoice->save();
            return [
                'status' => 'fail',
                'message' => 'Невозможно подобрать тариф',
            ];
        }
        $price += $tariff->price_for_day * $days;
        foreach ($reserve->reserveAdditionalServices as $id => $addService) {
            $service = $addService->additionalService;
            if ($service->type == AdditionalService::TYPE_WASH) {
                $price += $service->price;
            }
            if ($service->type == AdditionalService::TYPE_DELIVERY) {
                $price += $service->price;
            }
            if ($service->type == AdditionalService::TYPE_RENT) {
                $price += ($daysForAdditional * $service->price);
            }
        }

        Yii::$app->formatter->asTime($reserve->delivery_date, 'H');
        if (Yii::$app->formatter->asTime($reserve->delivery_date, 'H') >= 20 || Yii::$app->formatter->asTime($reserve->delivery_date, 'H') < 8) {
            $price += 0;
        }
        if (Yii::$app->formatter->asTime($reserve->return_date, 'H') >= 20 || Yii::$app->formatter->asTime($reserve->return_date, 'H') < 8) {
            $price += 0;
        }
        $child->invoice->price = $price - $reserve->invoice->price;
        $child->invoice->save();
        return [
            'status' => 'ok',
            'price' => $price - $reserve->invoice->price,
        ];
    }
}