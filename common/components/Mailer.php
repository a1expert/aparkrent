<?php

/*
 * This file is part of the EveRose project.
 *
 * (c) EveRose project <http://github.com/EveRose/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\components;

use Yii;
use yii\base\Component;

/**
 * Mailer.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Mailer extends Component
{
    /** @var string */
    public $viewPath = '@common/mail';

    /** @var string|array Default: `Yii::$app->params['adminEmail']` OR `no-reply@example.com` */
    public $sender;

    /** @var string */
    protected $welcomeSubject;

    /** @var string */
    protected $newPasswordSubject;

    /** @var string */
    protected $confirmationSubject;

    /** @var string */
    protected $reconfirmationSubject;

    /** @var string */
    protected $recoverySubject;

    /**
     * @return string
     */
    public function getWelcomeSubject()
    {
        if ($this->welcomeSubject == null) {
            $this->setWelcomeSubject('Welcome to ' . \Yii::$app->params['cabinetDomain']);
        }

        return $this->welcomeSubject;
    }

    /**
     * @param string $welcomeSubject
     */
    public function setWelcomeSubject($welcomeSubject)
    {
        $this->welcomeSubject = $welcomeSubject;
    }

    /**
     * @return string
     */
    public function getNewPasswordSubject()
    {
        if ($this->newPasswordSubject == null) {
            $this->setNewPasswordSubject('Your password on ' . \Yii::$app->params['cabinetDomain'] . ' has been changed');
        }

        return $this->newPasswordSubject;
    }

    /**
     * @param string $newPasswordSubject
     */
    public function setNewPasswordSubject($newPasswordSubject)
    {
        $this->newPasswordSubject = $newPasswordSubject;
    }

    /**
     * @return string
     */
    public function getConfirmationSubject()
    {
        if ($this->confirmationSubject == null) {
            $this->setConfirmationSubject('Confirm account on ' . Yii::$app->params['cabinetDomain']);
        }

        return $this->confirmationSubject;
    }

    /**
     * @param string $confirmationSubject
     */
    public function setConfirmationSubject($confirmationSubject)
    {
        $this->confirmationSubject = $confirmationSubject;
    }

    /**
     * @return string
     */
    public function getReconfirmationSubject()
    {
        if ($this->reconfirmationSubject == null) {
            $this->setReconfirmationSubject('Confirm email change on ' . Yii::$app->params['cabinetDomain']);
        }

        return $this->reconfirmationSubject;
    }

    /**
     * @param string $reconfirmationSubject
     */
    public function setReconfirmationSubject($reconfirmationSubject)
    {
        $this->reconfirmationSubject = $reconfirmationSubject;
    }

    /**
     * @return string
     */
    public function getRecoverySubject()
    {
        if ($this->recoverySubject == null) {
            $this->setRecoverySubject('Complete password reset on ' . Yii::$app->params['cabinetDomain']);
        }

        return $this->recoverySubject;
    }

    /**
     * @param string $recoverySubject
     */
    public function setRecoverySubject($recoverySubject)
    {
        $this->recoverySubject = $recoverySubject;
    }

    /**
     * Sends an email to a user after registration.
     *
     *
     * @param $password
     * @return bool
     */
    public function sendWelcomeMessage($user, $password)
    {
        $text = 'Для вас создан личный кабинет на ' . Yii::$app->params['cabinetDomain'] . '.';
        $text .= PHP_EOL;
        $text .= 'Логин: ' . $user->phone . ';';
        $text .= PHP_EOL;
        $text .= 'Пароль: ' . $password . '.';
        $text .= PHP_EOL;
        $text .= 'Прокат автомобилей "Автопарк"';
        return $this->sendMessage(
            $user->phone,
            $text
        );
    }

    public function sendCodeForRestore($user, $code)
    {
        $text = 'Код для сброса пароля в личном кабинете на ' . Yii::$app->params['cabinetDomain'] . ': ' . $code . '.';
        $text .= PHP_EOL;
        $text .= 'Прокат автомобилей "Автопарк"';
        return $this->sendMessage(
            $user->phone,
            $text
        );
    }

    /**
     * Sends an email to a user with recovery link.
     *
     * @param $user
     * @param $password
     * @return bool
     *
     */
    public function sendRecoveryMessage($user, $password)
    {
        $text = 'Ваш новый пароль для личного кабинета';
        $text .= ": $password";
        return $this->sendMessage(
            $user->phone,
            $text
        );
    }

    /**
     * @param string $to
     * @param $text
     * @return bool
     */
    protected function sendMessage($to, $text)
    {
        /** @var Sms $sms */
        $sms = Yii::$app->sms;
        return $sms->send($to, $text);
    }
}
