<?php
/**
 * Created at 12.10.2017 16:07
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\forms;

use backend\models\Client;
use backend\models\Invoice;
use backend\models\Reserve;
use backend\services\LoyaltyService;
use borales\extensions\phoneInput\PhoneInputValidator;
use yii\base\Model;

class ReserveForm extends Model
{
    public $client_id;
    public $model_id;
    public $date_from;
    public $date_to;
    public $name;
    public $phone;

    /**
     * @var Reserve $reserve
     */
    public $reserve;
    public $car_id;
    public $price;
    public $comment;
    public $paid_at;


    public function beforeValidate()
    {
        if($this->client_id == null) {
            if ($this->name == '') {
                $this->addError('name', 'Необходимо заполнить имя');
                return false;
            }
            if ($this->phone == '') {
                $this->addError('phone', 'Необходимо заполнить телефон');
                return false;
            }
        }
        return parent::beforeValidate();
    }

    public function setReserve($reserve)
    {
        $this->reserve = $reserve;
        $this->client_id = $reserve->client_id;
        $this->model_id = $reserve->model_id;
        $this->car_id = $reserve->car_id;
        $this->price = $reserve->price;
        $this->date_from = \Yii::$app->formatter->asDate($reserve->delivery_date, 'dd-MM-Y HH:mm');
        $this->date_to = \Yii::$app->formatter->asDate($reserve->return_date, 'dd-MM-Y HH:mm');
        $this->comment = $reserve->comment;
        $this->paid_at = $reserve->paidAt == null ? '' : \Yii::$app->formatter->asDate($reserve->paidAt, 'dd-MM-Y HH:mm');
    }

    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'required'],
            [['client_id', 'model_id', 'car_id'], 'integer'],
            [['date_from', 'date_to', 'name', 'comment', 'paid_at'], 'string'],
            [['phone'], PhoneInputValidator::className()],
            [['reserve'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'client_id' => 'Клиент',
            'phone' => 'Телефон нового клиента',
            'name' => 'Имя нового клиента',
            'model_id' => 'Модель',
            'date_from' => 'Дата получения',
            'date_to' => 'Дата возврата',
            'car_id' => 'Номер машины',
            'price' => 'Цена',
            'comment' => 'Примечание',
            'paid_at' => 'Дата оплаты',
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        if ($this->client_id == null) {
            $client = Client::findOne(['phone' => $this->phone]);
            if ($client == null) {
                $client = new Client();
                $client->phone = $this->phone;
                $client->type = Client::TYPE_INDIVIDUAL;
            }
            $client->name = $this->name;
            if ($client->save()) {
                $this->reserve->client_id = $client->id;
            } else {
                return false;
            }
        } else {
            $this->reserve->client_id = $this->client_id;
        }
        $this->reserve->car_id = $this->car_id;
        $this->reserve->model_id = $this->model_id;
        if (!$this->reserve->invoice) {
            $this->reserve->createInvoice();
        }
        $this->reserve->invoice->price = $this->price;

        $this->reserve->delivery_date = \Yii::$app->formatter->asTimestamp($this->date_from);
        $this->reserve->return_date = \Yii::$app->formatter->asTimestamp($this->date_to);
        $this->reserve->comment = $this->comment;
        if ($this->reserve->invoice->paid_at == null && $this->paid_at != '') {
            $result = $this->reserve->save();
            $this->reserve->invoice->paid_at = \Yii::$app->formatter->asTimestamp($this->paid_at);
            $loyaltyService = new LoyaltyService($this->reserve->client, $this->reserve->id);
            $loyaltyService->addBonusesToClient($this->reserve);
            $this->reserve->client->save(false);
        } else {
            $result = $this->reserve->save();
        }
        $this->reserve->invoice->save();
        return $result;
    }
}