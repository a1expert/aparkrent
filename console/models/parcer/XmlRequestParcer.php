<?php

namespace console\models\parcer;

use frontend\models\Reserve;
use common\models\ReserveAdditionalService;
use yii\base\Model;

class XmlRequestParcer extends Model
{
    public function importSoapRequest($xmlString)
    {
        $xpath = $this->openXml($xmlString);
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
                    $reserveAdditionalService->delivery_type = ReserveAdditionalService::DELIVERY_TO_CLIENT;
                    $reserveAdditionalService->address = $additionalServices[0]->getAttribute('Address');
                    $reserveAdditionalService->time = \Yii::$app->formatter->asTimestamp($additionalServices[0]->getAttribute('Time'));
                    $reserveAdditionalService->save();
                }
                $deliveryDate = $this->dateFormat($entry, 'DeliveryDate');
                $returnDate = $this->dateFormat($entry, 'ReturnDate');
                $reserve->delivery_date = \Yii::$app->formatter->asTimestamp($deliveryDate);
                $reserve->return_date = \Yii::$app->formatter->asTimestamp($returnDate);
                $reserve->model_id = $entry->getAttribute('ModelId');
                $reserve->invoice->price = $entry->getAttribute('Price');
                $reserve->save();
            }
        }
    }

    /**
     * @param $entry
     * @param $xmlAttribute
     * @return string
     */
    private function dateFormat($entry, $xmlAttribute)
    {
        $xmlDate = str_split($entry->getAttribute($xmlAttribute));
        $date = implode("-",[$xmlDate[0] . $xmlDate[1] . $xmlDate[2] . $xmlDate[3], $xmlDate[4] . $xmlDate[5], $xmlDate[6] . $xmlDate[7]]);
        return $date;
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
    private function openXml($xmlString)
    {
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
//        $doc->load(\Yii::getAlias('@console/data/reserve.xml'));
//        $doc->loadXML(file_get_contents(\Yii::getAlias('@console/data/reserve.xml')));
        $doc->loadXML($xmlString);
        return new \DOMXPath($doc);
    }

}

