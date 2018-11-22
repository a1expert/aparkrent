<?php

namespace common\models;

use yii\base\Model;

class SoapReserve extends Model
{
    public function soapExport()
    {
        $data = file_get_contents(\Yii::getAlias('@console/data/reserve.xml'));
        $wsdl = 'http://79.98.88.136:8080/prokatbs/ws/aparkrent.1cws?wsdl';
        $client = new \SoapClient($wsdl, [
            'login' => 'exchange',
            'password' => '7S0m0B0d',
            'cache_wsdl' => WSDL_CACHE_MEMORY,
        ]);

        $client->postOrder([
            'data' => $data,
        ]);
    }
}
