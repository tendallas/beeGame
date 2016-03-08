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
<div class="row">
    <?php $colNum = 12 / count($data); foreach($data as $beeType => $bees): ?>
    <div class="col-sm-<?= $colNum ?>">
        <h3><?= $beeType ?></h3>
        <img width="150" src="/images/bee.png" />
        <ul style="list-style: none">
            <?php foreach($bees as $bee): ?>
                <?php
                $class = 'success';
                switch($bee) {
                    case $bee <= 25:
                    {
                        $class = 'danger';
                    }
                    break;
                    case $bee <= 50:
                    {
                        $class = 'warning';
                    }
                    break;

                }
                ?>
                <li class="bee">
                    <div class="progress">
                        <div class="progress-bar progress-bar-<?= $class ?> progress-bar-striped" role="progressbar" aria-valuenow="<?= $bee ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $bee ?>%">
                            <span class="sr-only"><?=$bee ?>% hp left</span>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>
</div>
<p class="lead">
    <a href="#" class="btn btn-lg btn-default hit">Hit the bee</a>
</p>