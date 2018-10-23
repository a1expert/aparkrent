<?php
/**
 * Created by PhpStorm.
 * User: Vlad_Rizhyi
 * Date: 23.08.2018
 * Time: 13:33
 */

namespace console\models\parcer;


use common\models\AutoModel;
use yii\base\Model;

class XmlParcer extends Model
{
    private $arr =[];

    public function importCatalog()
    {
        $this->clearTestFile();
        $xpath = $this->openXml();
        $query = '//FreeModels/Model';
        $entries = $xpath->query($query);
        foreach ($entries as $entry) {
            $auto_model = AutoModel::findOne(['code' => $entry->getAttribute('Code')]);

            if (!empty($auto_model)) {
                $auto_model->code = $entry->getAttribute('Code');
                $auto_model->count_free = $entry->getAttribute('CountFree');
                $auto_model->count_total = $entry->getAttribute('CountTotal');
                $auto_model->save();
            }
        }
//        $this->printArray($this->arr);

    }


    private function openXml(){
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->load(\Yii::getAlias('@console/data/FreeModels.xml'));
        return new \DOMXPath($doc);
    }

    private function printArray($arr,$unique=null){
        $unique ? $arr = array_unique($arr): false;
        foreach ($arr as $item) {
            file_put_contents(\Yii::getAlias('@console/data/test.txt'), serialize($item) . PHP_EOL, FILE_APPEND);
        }
        return true;
    }

    private function clearTestFile(){
        file_put_contents(\Yii::getAlias('@console/data/test.txt'), '');
    }

}

