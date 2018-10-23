<?php

namespace backend\forms;

use backend\models\CrmUser;
use borales\extensions\phoneInput\PhoneInputValidator;
use yii\base\Model;


/**
 * LoginForm is the model behind the login form.
 *
 * @property CrmUser|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $phone;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // phone and password are both required
            [['phone', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['phone', PhoneInputValidator::class],
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
            'phone' => 'Телефон',
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
                $this->addError($attribute, 'Неверный телефон или пароль.');
            }
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
     * @return CrmUser|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = CrmUser::find()->where(['phone' => $this->phone])->andWhere(['blocked_at' => null])->one();
        }

        return $this->_user;
    }
}
