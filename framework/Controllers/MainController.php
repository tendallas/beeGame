<?php
namespace framework\Controllers;

use framework\Core\ControllerBase;
use framework\Helpers\Request;

class MainController extends ControllerBase
{
    public function actionIndex()
    {
        if (Request::isAJAX()) {
            $aResponse = [];
            switch($_POST['act']) {
                case 'start':
                {
                    $_SESSION['in_game'] = true;
                    $aResponse['template'] = $this->view->render('game', $_SESSION['stats']);
                }
                break;
                case 'hit':
                {
                    if (isset($_SESSION['out_game'])) {
                        $aResponse['template'] = $this->view->render('game-over');
                        $aResponse['reload'] = true;
                        session_destroy();
                        break;
                    }
                    $aResponse['template'] = $this->view->render('game', $_SESSION['stats']);
                }
                break;
            }
            $this->ajaxResponse($aResponse);
        }
        if (isset($_SESSION['in_game']) && $_SESSION['in_game'] === true) {
            $this->view->generate('game', $_SESSION['stats']);
            exit();
        }
        $this->view->generate('index');
    }
}