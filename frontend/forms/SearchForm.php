<?php
namespace frontend\forms;

use yii\base\Model;

class SearchForm extends Model
{
    public $class_id;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'string'],
            [['class_id'], 'integer'],
        ];
    }
}