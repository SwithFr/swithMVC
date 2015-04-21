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
</div>

</body>
</html>


