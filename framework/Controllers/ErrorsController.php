<?php
namespace framework\Controllers;

use framework\Core\ControllerBase;

class ErrorsController extends ControllerBase
{
    public function actionIndex()
    {
        $this->action500();
    }

    public function action500()
    {
        $this->view->generate('500');
    }

    public function action404()
    {
        $this->view->generate('404');
    }
}
