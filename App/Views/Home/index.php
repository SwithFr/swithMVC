<?php $title_for_layout = "Bienvenue sur le Framework Swith";
    if ($_ENV['SALT_KEY'] == '2129762b19c044ab7f49ea8995f7795e886ea4be') {
        echo "<div class='alert alert-warning'>Pensez à bien modifier la clé de sécurité dans le fichier <code>App/Config/*.env</code> correspondant à votre environnment actuel !</div>";
    }else {
        echo "<div class='alert alert-success'>Le fichier <code>App/Config/*.env</code> correspondant à votre environnment actuel est correct.</div>";
    }
    if ($_ENV['DB_HOST'] == 'host_name' || $_ENV['DB_LOGIN'] == 'database_login') {
        echo "<div class='alert alert-warning'>Configurez votre fichier <code>App/Config/app_config.php</code> avant tout !</div>";
    } else {
        echo "<div class='alert alert-success'>Votre fichier <code>App/Config/app_config.php</code> est bien configuré !</div>";
    }
?>

<p class="info">
    Page d'accueil par defaut du framework. Vous pouvez la supprimer ou la modifier. Elle appelée par le controller <code>Home</code> et l'action <code>index</code>.
</p>