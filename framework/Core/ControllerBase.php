<?php
namespace framework\Core;

/**
 * Class ControllerBase
 * @package framework\Controllers
 */
class ControllerBase
{
    /**
     * @var ModelBase
     */
    public $model;
    /**
     * @var ViewBase
     */
    public $view;

    /**
     * ControllerBase constructor.
     */
    public function __construct()
    {
        $this->view = new ViewBase();
    }

    /**
     * @param $response
     */
    public function ajaxResponse($response)
    {
        echo json_encode(['data' => $response]);
        exit();
    }
}
