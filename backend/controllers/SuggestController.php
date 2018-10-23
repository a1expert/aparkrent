<?php

namespace backend\controllers;

use yii\base\Exception;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\web\Controller;

class SuggestController extends Controller
{
    const TOKEN = 'f5b2999722507d36bc424a88459e965c5579c08d';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionBik($query)
    {
        $url = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank';
        $method = 'post';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . self::TOKEN,
        ];
        $content = json_encode(['query' => $query]);
        $client = new Client();
        $request = $client->createRequest()
            ->setHeaders($headers)
            ->setMethod($method)
            ->setUrl($url)
            ->setContent($content);

        $response = $request->send();
        $array = json_decode($response->getContent());
        try {
            return json_encode($array->suggestions[0]);
        } catch (Exception $e) {
            return null;
        }
    }

    public function actionInn($query)
    {
        $method = 'post';
        $url = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . self::TOKEN,
        ];
        $content = json_encode(['query' => $query]);
        $client = new Client();
        $request = $client->createRequest()
            ->setHeaders($headers)
            ->setMethod($method)
            ->setUrl($url)
            ->setContent($content);

        $response = $request->send();
        $array = json_decode($response->getContent());
        try {
            return json_encode($array->suggestions[0]);
        } catch (Exception $e) {
            return null;
        }
    }
}