<?php

/**
 * !!!!! КЛАСС НЕ РАБОТАЕТ!!!! ТОЛЬКО ДЛЯ PHPDOC !!!!!!
 *
 * Переопределяем Yii класс для нормального автокомплита своих компонент
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property backend\models\CrmUser|cabinet\models\User $user The user component. This property is read-only. Extended component.
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 */
class ConsoleApplication extends yii\console\Application
{
}