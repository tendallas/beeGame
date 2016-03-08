<?
use framework\Helpers\Tpl;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->title ?></title>

    <?php foreach(Tpl::$includesCSS as $v): ?>
        <link rel="stylesheet" href="<?= $v; ?>" type="text/css" />
    <?php endforeach; ?>
</head>

<body>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand"><?= $this->title ?></h3>
                </div>
            </div>
            <div class="inner cover">
                <?php include $contentView; ?>
            </div>
            <div class="mastfoot">
                <div class="inner">
                    <p>Game by <a target="_blank" href="https://plus.google.com/u/0/+TenDallasUA/posts">Andrey Frolov</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach(Tpl::$includesJS as $v): ?>
    <script src="<?= $v ?>" type="text/javascript" charset="utf-8"></script>
<?php endforeach; ?>
<?php if (!empty(Tpl::$registerJS)): ?>
<script type="text/javascript">
    $(function() {
        <?php foreach(Tpl::$registerJS as $v): ?>
            <?= $v ?>
        <?php endforeach; ?>
    });
</script>
<?php endif; ?>
</body>
</html>
