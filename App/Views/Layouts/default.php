<?php use Core\Helpers\Html; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title_for_layout) ? $title_for_layout : ''; ?></title>
    <?= Html::css('default'); ?>
</head>
<body>

<?= $this->Session->flash(); ?>

<div class="container">
    <?= $content_for_layout; ?>
</div>

</body>
</html>


