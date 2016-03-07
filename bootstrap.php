<?php
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('FW', __DIR__ . DS . 'framework');
define('STATS', __DIR__ . DS . 'framework' . DS . 'logs');

error_reporting(E_ALL);

set_error_handler(
    function ($code, $description) {
        throw new ErrorException($description, $code);
    }
);

require_once 'autoload.php';
