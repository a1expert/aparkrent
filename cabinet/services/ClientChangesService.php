<?php
/**
 * Created at 07.10.2017 17:18
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
namespace cabinet\services;

use cabinet\models\ClientChange;

class ClientChangesService
{
    public $client;
    public $changeModel;
    public $ignoreArray = ['id', 'phone'];

    public function setChangeModels()
    {
        $count = 0;
        foreach ($this->client->attributes as $name => $attribute) {
            if (!in_array($name, $this->ignoreArray) && ($attribute != $this->client->getOldAttribute($name))) {
                $exist = $this->checkForExist($name);
                if ($exist) {
                    $this->changeModel->new_value = $attribute;
                    if ($this->changeModel->save()) {
                        $count++;
                    }
                } else {
                    $this->changeModel = new ClientChange();
                    $this->changeModel->attribute = $name;
                    $this->changeModel->client_id = $this->client->id;
                    $this->changeModel->old_value = strval($this->client->getOldAttribute($name));
                    $this->changeModel->new_value = strval($attribute);
                    if ($this->changeModel->save()) {
                        $count++;
                    }
                }
            }
        }
        return $count;
    }

    public function checkForExist($name)
    {
        $this->changeModel = ClientChange::find()->where(['client_id' => $this->client->id])->andWhere(['attribute' => $name])->one();
        return $this->changeModel != null;
    }
}