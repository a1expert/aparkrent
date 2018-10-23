<?php

namespace cabinet\forms;

use cabinet\models\User;
use yii\base\Model;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    const PHONE_MASK = '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/';
    const EMAIL_MASK = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    public $login;
    public $password;
    public $rememberMe = true;
    public $isPhone = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // phone and password are both required
            [['login', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['login', 'string'],
            ['login', 'validateLogin'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Телефон или E-mail',
            'password' => 'Пароль',
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный телефон(E-mail) или пароль.');
            }
        }
    }

    public function validateLogin($attribute)
    {
        $this->isPhone = preg_match(self::PHONE_MASK, $this->$attribute) != 0;
        if (!$this->isPhone && preg_match(self::EMAIL_MASK, $this->$attribute) == 0) {
            $this->addError($attribute, 'Неверный телефон(E-mail) или пароль.');
        }
    }

    /**
     * Logs in a user using the provided phone and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[phone]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            if ($this->isPhone) {
                $this->login = str_replace(['-', '(', ')', ' '], '', $this->login);
                $this->login = preg_replace('/^8/', '+7', $this->login);
                $this->_user = User::find()->where(['phone' => $this->login])->andWhere(['blocked_at' => null])->one();
            } else {
                $this->_user = User::find()->where(['email' => $this->login])->andWhere(['blocked_at' => null])->one();
            }
        }

        return $this->_user;
    }
}
