<?php
use framework\Helpers\Tpl;

$params = json_encode([
    'url' => '/main/index'
]);
$script = <<<JS
mainIndex.init($params);
JS;

Tpl::includeJS(['main.index']);
Tpl::registerJS($script);
?>
<h1 class="cover-heading">Welcome to my simple game.</h1>
<p class="lead">To play, click a button that enables a user to “hit” a random bee. The selection of a
    bee are random. When the bees are all dead, the game will reset itself with
    full life bees for another round.</p>
<p class="lead">
    <a href="#" class="btn btn-lg btn-default start-game">Start game</a>
</p>
