<?php
/**
 * Created at 25.11.2017 15:54
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace cabinet\forms;


use borales\extensions\phoneInput\PhoneInputValidator;
use cabinet\models\User;
use Yii;
use yii\base\Model;

class RestoreForm extends Model
{
    public $phone;
    public $reset_token;
    public $password;
    public $repeat_password;

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_RESET_CODE_SEND = 'resetCodeSend';
    const SCENARIO_RESET_CODE_SUCCESS = 'resetCodeSuccess';

    public function rules()
    {
        return [
            [['phone', 'reset_token'], 'string', 'max' => 12],
            [['phone'], 'required'],
            [['phone'], 'validatePhone'],
            [['phone'], PhoneInputValidator::class],
            [['reset_token'], 'required', 'on' => self::SCENARIO_RESET_CODE_SEND],
            [['reset_token'], 'validateToken', 'on' => self::SCENARIO_RESET_CODE_SEND],
            [['password', 'repeat_password'], 'string', 'min' => 6],
            [['password', 'repeat_password'], 'required', 'on' => self::SCENARIO_RESET_CODE_SUCCESS],
            [['repeat_password'], 'validatePassword', 'on' => self::SCENARIO_RESET_CODE_SUCCESS],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'reset_token' => 'Код',
            'password' => 'Пароль',
            'repeat_password' => 'Повторите пароль',
        ];
    }

    public function validatePhone($attribute)
    {
        if (!User::findByPhone($this->phone)) {
            $this->addError($attribute, 'Телефон указан неверно');
        }
        return false;
    }

    public function validatePassword($attribute)
    {
        if ($this->password != $this->repeat_password) {
            $this->addError($attribute, 'Пароли не совпадают');
        }
        return false;
    }

    public function validateToken($attribute)
    {
        $user = User::findByPhone($this->phone);
        if (!Yii::$app->security->validatePassword($this->reset_token, $user->password_reset_token)) {
            $this->addError($attribute, 'Код неверный');
        }
    }

    public function sendCode()
    {
        if (!$user = User::findByPhone($this->phone)){
            return false;
        }
        $user->sendCodeForRestore();
    }

    public function setNewPassword()
    {
        if (!$user = User::findByPhone($this->phone)){
            return false;
        }
        $user->setPassword($this->password);
        $user->save(false);
    }
}