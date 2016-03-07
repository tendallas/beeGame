<?php
use application\ClientInterface\CGI;
use application\ClientInterface\Cli;
use application\GamePlay\Game;
use framework\Core\Route;

require_once __DIR__ . '/../bootstrap.php';

$clientInterface = PHP_SAPI == 'cli' ? new Cli() : new CGI();

$game = new Game($clientInterface);
$game->play();
if ($clientInterface instanceof CGI) {
    Route::start();
}
