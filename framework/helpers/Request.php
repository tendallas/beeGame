<?php
namespace framework\helpers;

/**
 * Class Request
 * @package framework\helpers
 */
abstract class Request
{
    /**
     * @var
     */
    private static $controller;
    /**
     * @var
     */
    private static $action;

    /**
     * @param $url
     * @param null $status
     */
    public static function redirect($url, $status = null)
    {
        header('Location: http://' . $url, true, $status);
        exit();
    }

    /**
     * Выполняется ли POST запрос
     * @return boolean
     */
    public static function isPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Выполняется ли POST запрос
     * @return boolean
     */
    public static function isGET()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /**
     * @return boolean
     */
    public static function isAJAX()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * HTTP_HOST value
     * @return string
     */
    public static function host()
    {
        return static::getSERVER('HTTP_HOST');
    }

    /**
     * Значение REQUEST_URI
     * @param string $defaultValue значение по-умолчанию
     * @return string
     */
    public static function uri($defaultValue = '')
    {
    }

    /**
     * URL Запроса
     * @param boolean $addURI false - добавлять значение REQUEST_URI
     * @return mixed
     */
    public static function url($addURI = false)
    {
    }

    /**
     * @param string $defaultValue
     * @return string
     */
    public static function referer($defaultValue = '')
    {
        return static::getSERVER('HTTP_USER_AGENT');
    }

    /**
     * HTTP_USER_AGENT
     * @return mixed
     */
    public static function userAgent()
    {
        return static::getSERVER('HTTP_USER_AGENT');
    }

    /**
     * @return string
     */
    public static function method()
    {
        return static::getSERVER('REQUEST_METHOD');
    }

    /**
     * value from SERVER array
     * @param string $key ключ
     * @return string
     */
    public static function getSERVER($key)
    {
        return $_SERVER[$key];
    }

    /**
     * @return mixed
     */
    public static function getController()
    {
        return static::$controller;
    }

    /**
     * @param $controller
     */
    public static function setController($controller)
    {
        static::$controller = $controller;
    }

    /**
     * @return mixed
     */
    public static function getAction()
    {
        return static::$action;
    }

    /**
     * @param $action
     */
    public static function setAction($action)
    {
        static::$action = $action;
    }
}