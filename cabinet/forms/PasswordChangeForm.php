<?php
/**
 * Created by PhpStorm.
 * User: Sultanov
 * Date: 05.10.2017
 * Time: 19:41
 */

namespace cabinet\forms;


use yii\base\Model;

class PasswordChangeForm extends Model
{
    public $password;
    public $new_password;
    public $new_password_again;

    public function rules()
    {
        return [
            [['password', 'new_password', 'new_password_again'], 'required'],
            [['password', 'new_password', 'new_password_again'], 'string', 'min' => 6],
            [['new_password_again'], 'validatorDouble'],
            [['new_password'], 'validatorDifferent'],
            [['password'], 'validatorPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Текущий пароль',
            'new_password' => 'Новый пароль',
            'new_password_again' => 'Повторите новый пароль',
        ];
    }

    public function validatorDouble($attribute)
    {
        if ($this->$attribute != $this->new_password) {
            $this->addError($attribute, 'Пароли не совпадают');
        }
    }

    public function validatorDifferent($attribute)
    {
        if ($this->password == $this->$attribute) {
            $this->addError($attribute, 'Новый пароль не должен совпадать со старым');
        }
    }

    public function validatorPassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = \Yii::$app->user->identity;

            if (!$user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Пароль не подходит');
            }
        }
    }

    public function changePassword()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = \Yii::$app->user->identity;
        $user->password_hash = \Yii::$app->security->generatePasswordHash($this->new_password);
        if ($user->save()) {
            return true;
        }
        return false;
    }
}