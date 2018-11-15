<?php

namespace console\models\parcer;

use frontend\models\Reserve;
use common\models\ReserveAdditionalService;
use yii\base\Model;

class XmlRequestParcer extends Model
{
    public function importSoapRequest()
    {
        $xpath = $this->openXml();
        $query = '//AllReserve/ReserveCar';
        $entries = $xpath->query($query);
        foreach ($entries as $entry) {
            $reserve = Reserve::findOne(['id' => $entry->getAttribute('ReserveId')]);
            if (!empty($reserve)) {
                ReserveAdditionalService::deleteAll(['reserve_id' => $reserve->id]);
                $additionalServices = $xpath->query('AdditionalServices', $entry);
                $optionalEquipment = $xpath->query('OptionalEquipment', $entry);

                $this->additionalService($reserve->id, $additionalServices, $optionalEquipment, 'VideoRecorder');
                $this->additionalService($reserve->id, $additionalServices, $optionalEquipment, 'Navigator');
                $this->additionalService($reserve->id, $additionalServices, $optionalEquipment, 'BabySeat');

                $reserveAdditionalServices = ReserveAdditionalService::findAll(['reserve_id' => $reserve->id]);
                if (empty($reserveAdditionalServices)) {
                    $reserveAdditionalService = new ReserveAdditionalService();
                    $reserveAdditionalService->reserve_id = $reserve->id;
                    $reserveAdditionalService->address = $additionalServices[0]->getAttribute('Address');
                    $reserveAdditionalService->time = \Yii::$app->formatter->asTimestamp($additionalServices[0]->getAttribute('Time'));
                    $reserveAdditionalService->save();
                }

                $reserve->model->code = $entry->getAttribute('ModelCode');
                $reserve->model_id = $entry->getAttribute('ModelId');
                $reserve->delivery_date = $entry->getAttribute('DeliveryDate');
                $reserve->return_date = $entry->getAttribute('ReturnDate');
                $reserve->invoice->price = $entry->getAttribute('Price');
                $reserve->save();
            }
        }
    }

    /**
     * @param $reserve_id
     * @param $additionalServices
     * @param $optionalEquipment
     * @param $option
     */
    private function additionalService($reserve_id, $additionalServices, $optionalEquipment, $option)
    {
        if ($optionalEquipment[0]->getAttribute($option) == 'да') {
            $reserveAdditionalService = new ReserveAdditionalService();
            $reserveAdditionalService->reserve_id = $reserve_id;
            $reserveAdditionalService->address = $additionalServices[0]->getAttribute('Address');
            $reserveAdditionalService->time = \Yii::$app->formatter->asTimestamp($additionalServices[0]->getAttribute('Time'));
            $reserveAdditionalService->additional_service_id = $option != 'VideoRecorder' ? $option == 'Navigator' ? 11 : 12 : 10;
            $reserveAdditionalService->save();
        }
    }

    /**
     * @return \DOMXPath
     */
    private function openXml()
    {
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->load(\Yii::getAlias('@console/data/reserve.xml'));
        return new \DOMXPath($doc);
    }

}

