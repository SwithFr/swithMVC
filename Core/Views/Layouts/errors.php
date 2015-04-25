<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title_for_layout; ?></title>
</head>
<body>

<?= $this->Session->flash(); ?>

<div class="container">
    <?= $content_for_layout; ?>
    <?= \Core\Helpers\Html::link($this->request->referer,'Retour'); ?>
</div>

</body>
</html>