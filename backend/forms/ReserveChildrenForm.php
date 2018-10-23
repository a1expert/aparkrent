<?php
/**
 * Created at 07.11.2017 19:09
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\forms;

use backend\models\AdditionalService;
use backend\models\ReserveChild;
use yii\base\Model;

class ReserveChildrenForm extends Model
{
    /**
     * @var ReserveChild $child
     */
    public $child;
    public $type;
    public $date_to;
    public $date_from;
    public $reserve_id;
    public $price;
    public $service_id;
    public $service_type_id;

    public function rules()
    {
        return [
            [['type'], 'validatorType'],
            [['type'], 'required'],
            [['type', 'reserve_id', 'service_id', 'service_type_id'], 'integer'],
            [['type', 'reserve_id'], 'required'],
            [['price'], 'number'],
            [['date_to', 'date_from'], 'string'],
            [['child'], 'safe'],
        ];
    }

    public function validatorType($attribute)
    {
        if ($this->$attribute == ReserveChild::TYPE_ADDITIONAL_SERVICE_FOR_TIME) {
            if ($this->service_id == '') {
                $this->addError('service_id', 'Обязательно для заполнения');
                return;
            }
            $service = AdditionalService::findOne($this->service_id);
            if (!$service) {
                $this->addError('service_id', 'Несуществующая услуга');
            }
            if ($service->type == AdditionalService::TYPE_RENT) {
                if ($this->date_from == '') {
                    $this->addError('date_from', 'Обязательно для заполнения');
                    return;
                }
            }
        } else {
            if ($this->date_to == '') {
                $this->addError('date_from', 'Обязательно для заполнения');
                return;
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Тип',
            'price' => 'Цена',
            'date_to' => 'До',
            'date_from' => 'С',
            'service_id' => 'Услуга',
        ];
    }

    public function setChildForm(ReserveChild $child)
    {
        $this->child = $child;
        $this->type = $child->type;
        $this->price = $child->invoice->price;
        $this->date_to = $child->date_to == null ? '' : \Yii::$app->formatter->asDate($child->date_to, 'dd-MM-Y HH:mm');
        $this->service_id = $child->service_id;
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        if ($this->child->invoice == null) {
            $this->child->createInvoice();
            $this->child->invoice->price = $this->price;
            $this->child->invoice->save(false);
        } else {
            $this->child->invoice->price = $this->price;
            $this->child->invoice->save(false);
        }
        $this->child->type = $this->type;
        $this->child->reserve_id = $this->reserve_id;
        $this->child->date_to = $this->date_to == '' ? null : \Yii::$app->formatter->asTimestamp($this->date_to);
        $this->child->date_from = $this->date_from == '' ? null : \Yii::$app->formatter->asTimestamp($this->date_from);
        $this->child->service_id = $this->service_id;
        return $this->child->save();
    }
}