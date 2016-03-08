<?php
namespace framework\Helpers;

/**
 * Class Tpl
 * @package framework\Helpers
 */
class Tpl
{
    /**
     * @var array
     */
    public static $includesJS = [
        '/js/jquery.js',
        '/js/core/core.js'
    ];
    /**
     * @var array
     */
    public static $registerJS = [];
    /**
     * @var array
     */
    public static $includesCSS = [];

    /**
     * @param array $mInclude
     * @param bool $bAddUrl
     * @return bool
     */
    public static function includeJS($mInclude, $bAddUrl = true)
    {
        if (empty($mInclude)) {
            return false;
        }

        if (!is_array($mInclude)) {
            $mInclude = array($mInclude);
        }
        foreach ($mInclude as $c) {
            if (!isset(static::$includesJS[$c])) {
                static::$includesJS[$c] = ($bAddUrl ? '/js/' . $c . '.js' : $c . '.js');
            }
        }

        return true;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function registerJS($code)
    {
        if (empty($code)) {
            return false;
        }

        if (!isset(static::$registerJS[$code])) {
            static::$registerJS[$code] = $code;
        }

        return true;
    }

    /**
     * @param array $mInclude
     * @param bool $bAddUrl
     * @return bool
     */
    public static function includeCSS($mInclude, $bAddUrl = true)
    {
        if (empty($mInclude)) return false;

        if (!is_array($mInclude)) {
            $mInclude = array($mInclude);
        }
        foreach ($mInclude as $c) {
            if (!isset(static::$includesCSS[$c])) {
                static::$includesCSS[$c] = ($bAddUrl ? '/css/' . $c . '.css' : $c . '.css');
            }
        }

        return true;
    }
}
