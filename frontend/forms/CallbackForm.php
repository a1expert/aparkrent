<?php

namespace frontend\forms;

use yii\base\Model;

class CallbackForm extends Model
{
    public $name;
    public $email;
    public $message;
    public $title;

    public function rules()
    {
        return [
            [['name', 'email', 'title'], 'required'],
            [['name', 'title'], 'string', 'max' => 50],
            [['message'], 'string'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Электронный адрес',
            'message' => 'Сообщение',
        ];
    }

    public function sendMessage()
    {
        $emails = ['info@aparkrent.ru', 'admin@goldcarrot.ru'];
        foreach ($emails as $email) {
            \Yii::$app->mailer->compose('mail', [
                'form' => $this,
            ])
                ->setTo($email)
                ->setFrom(['admin@goldcarrot.ru' => 'Gold Carrot'])
                ->setSubject('Форма "' . $this->title . '" с сайта aparkrent.ru')
                ->send();
        }
        return true;
    }
}