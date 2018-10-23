<?php
/**
 * Created by PhpStorm.
 * User: Vlad_Rizhyi
 * Date: 10.08.2018
 * Time: 17:29
 */

namespace console\controllers;


use console\models\parcer\XmlParcer;
use yii\console\Controller;

class XmlController extends Controller
{

    public function actionImport()
    {
        $time = microtime(true);

        $parcer = new XmlParcer();
        $parcer->importCatalog();


        echo microtime(true) - $time;
        return true;
    }

    public function actionImportTest()
    {
        $doc = new \DOMDocument();
        file_put_contents(\Yii::getAlias('@console/data/test.txt'), '');
        $doc->preserveWhiteSpace = false;
        $doc->load(\Yii::getAlias('@console/data/FreeModels.xml'));
        $xpath = new \DOMXPath($doc);

        $query = '//FreeModels/Model[@Name = "Kia Picanto GT-Line 2018"]';
        $entries = $xpath->query($query);
        $arr = [];
        foreach ($entries as $entry) {
            $arr[] = $entry->nodeValue;
        }

        $arr = array_unique($arr);
        foreach ($arr as $item) {
            file_put_contents(\Yii::getAlias('@console/data/test.txt'), serialize($item) . PHP_EOL, FILE_APPEND);
        }
        file_put_contents(\Yii::getAlias('@console/data/test.txt'), PHP_EOL . PHP_EOL, FILE_APPEND);


        foreach ($arr as $type) {
            $query = '//FreeModels';
            $entries = $xpath->query($query);
            foreach ($entries as $entry) {
                $params = $xpath->query('Model', $entry);
                if ($params[0]->nodeValue == $type) {
                    foreach ($params as $item) {
                        $arr[$type][] = $item->getAttribute('Name');
                        $arr[$type][] = $item->getAttribute('Code');
                        $arr[$type][] = $item->getAttribute('CountFree');
                        $arr[$type][] = $item->getAttribute('CountTotal');
                    }
                }
            }

//            $arr[$type] = array_unique($arr[$type]);
            foreach ($arr[$type] as $item) {
                file_put_contents(\Yii::getAlias('@console/data/test.txt'), serialize($item) . PHP_EOL, FILE_APPEND);
            }
            file_put_contents(\Yii::getAlias('@console/data/test.txt'), PHP_EOL . PHP_EOL, FILE_APPEND);
        }

    }


}