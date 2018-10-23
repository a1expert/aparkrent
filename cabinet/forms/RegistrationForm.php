<?php

namespace cabinet\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use cabinet\models\User;
use yii\base\Model;
use yii\web\ServerErrorHttpException;

class RegistrationForm extends Model
{
    public $phone;
    public $password;
    /**
     * @var User
     */
    public $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // phone and password are both required
            [['phone'], 'required'],
            [['phone'], PhoneInputValidator::class],
            [['phone'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'phone'],
            // password is validated by validatePassword()
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
        ];
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     * @return bool
     * @throws ServerErrorHttpException
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->user = \Yii::createObject(User::className());
        $this->loadAttributes($this->user);
        if (!$this->user->register()) {
            return false;
        }

        \Yii::$app->session->setFlash('info', 'Аккаунт создан');

        return true;
    }

    /**
     * Loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * By default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param User $user
     */
    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
    }
}