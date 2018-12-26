<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 15.12.2018
 * Time: 19:11
 */

namespace backend\models;


class ModelGallery extends  \common\models\ModelGallery
{
    public static function getFullGallery(){
        return self::find()->all();
    }

    public static function saveGallery($array, $id)
    {
        if ($id == null ) {
            return false;
        }
        self::deleteAll(['model_id' => $id]);
        if ($array == null) {
            return false;
        }

        foreach ($array as $photo) {
            $model = new self();
            $model->photo = $photo;
            $model->model_id = $id;
            if ($model->validate()){
                $model->save();
            }
        }

        return true;
    }
}