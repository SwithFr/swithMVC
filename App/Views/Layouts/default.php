<?php use Core\Helpers\Html; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title_for_layout) ? $title_for_layout : ''; ?></title>
    <?= Html::css('default'); ?>
</head>
<body>
<header>
    <h1 class="title--center"><em>Bienvenue !</em> <br/>Bonne utilisation de Swith Framework !</h1>
    <p class="doc-help">Si vous avez besoin d'aide, consultez la documentation ici : <a
            href="http://mvc.swith.fr/pages/documentation/commencer" class="doc-link">Documentation</a></p>
</header>
<?= $this->Session->flash(); ?>

<div class="container">
    <?= $content_for_layout; ?>
</div>

</body>
</html>


