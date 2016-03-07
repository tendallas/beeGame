<?php
namespace framework\Core;

use framework\helpers\Request;

/**
 * Class Route
 * @package framework\Core
 */
class Route
{

    /**
     * Executing router
     * @return void
     */
    public static function start()
    {
        $controllerName = 'main';
        $actionName = 'index';
        $ext = '.php';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        if ($controllerName == 'index.php') {
            Request::redirect(Request::host());
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        Request::setController($controllerName);
        Request::setAction($actionName);

        $controllerName = ucfirst($controllerName) . 'Controller';
        $actionName = 'action' . ucfirst($actionName);

        $controller = '\\framework\\Controllers\\' . $controllerName;
        if (!class_exists($controller)) {
            Route::error404();
        }
        $controller = new $controller();

        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
        } else {
            Route::error404();
        }

    }

    /**
     * Return 404 action
     * @return void
     */
    public static function error404()
    {
        $controller = '\\framework\\Controllers\\ErrorsController';
        if (!class_exists($controller) || !method_exists($controller, 'action404')) {
            $host = 'http://' . $_SERVER['HTTP_HOST'];
            header('HTTP/1.1 404 Not Found');
            header("Status: 404 Not Found");
            exit();
        }

        Request::setController('errors');
        Request::setAction('404');

        $controller = new $controller();
        $controller->action404();
        exit();
    }
}
