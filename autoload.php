<?php

spl_autoload_register(
    function ($class) {
        $file = __DIR__ . DS . str_replace('\\', DS, $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
);
