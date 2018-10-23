<?php
/**
 * Created at 03.11.2017 18:30
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\forms;


use backend\models\Fine;
use backend\models\Invoice;
use yii\base\Model;

class FineForm extends Model
{
    public $reserve_id;
    public $date;
    public $paragraph;
    public $resolution_number;
    public $price;
    public $image;
    public $fine;

    public function rules()
    {
        return [
            [['reserve_id'], 'integer'],
            [['price'], 'number'],
            [['date', 'image', 'resolution_number', 'paragraph'], 'string'],
            [['price', 'reserve_id'], 'required'],
            [['fine'], 'safe'],
        ];
    }

    public function setFromFine(Fine $fine)
    {
        $this->fine = $fine;
        $this->reserve_id = $fine->reserve_id;
        $this->date = \Yii::$app->formatter->asDate($fine->date, 'dd-MM-Y');
        $this->paragraph = $fine->paragraph;
        $this->image = $fine->image;
        $this->resolution_number = $fine->resolution_number;
        $this->price = $fine->invoice->price;
    }

    public function saveFine()
    {
        if ($this->fine == null) {
            $this->fine = new Fine();
            $this->fine->reserve_id = $this->reserve_id;
            $invoice = new Invoice();
            $invoice->price = $this->price;
            $invoice->save(false);
            $this->fine->invoice_id = $invoice->id;
        } else {
            if ($this->fine->invoice->paid_at == null) {
                $this->fine->invoice->price = $this->price;
                $this->fine->invoice->save();
            }

        }
        $this->fine->date = \Yii::$app->formatter->asTimestamp($this->date);
        $this->fine->paragraph = $this->paragraph;
        $this->fine->resolution_number = $this->resolution_number;
        $this->fine->image = $this->image;
        return $this->fine->save();
    }

    public function attributeLabels()
    {
        return [
            'price' => 'Цена',
            'image' => 'Изображение',
            'date' => 'Дата',
            'paragraph' => 'Пункт ПДД',
            'resolution_number' => 'Номер постановления',
        ];
    }
}