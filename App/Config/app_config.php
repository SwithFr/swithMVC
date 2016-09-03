<?php

return [
    /**
     * Le nom de votre application, vous pouvez vous en servir pour le titre de vos pages par exemple
     */
    'name' => 'Titre de mon site',

    /**
     * L'action appelée par défaut au sein de votre application
     * (utilisé pour la page d'accueil par exemple)
     */
    'default_action' => 'index',

    /**
     * Le controller appelé par défaut
     * tout comme l'action, il est utilisé pour la page d'accueil
     */
    'default_controller' => 'home',

    /**
     * Les préfixes que souhaitez rendre disponibles
     * pratique pour limiter certaines actions
     * à des utilisateurs dont le rôle correpond à un prefixe
     */
    'prefixes' => ['admin', 'user'],

    /**
     * Vos environnements de développement.
     * Vous pouvez en définir autant que vous voulez, par défaut il y en a 3
     * si vous souhaitez en ajouter il vous faudra créer les fichiers correspondants
     * en vous basant sur ceux déjà existants.
     *
     * Le principe est simple, vous définissez une IP que vous associez à un fichier
     * d'envrionnement. Ainsi vous pouvez avoir plusieurs configurations pour
     * la base de données et ne pas avoir à faire les modifications à chaque fois
     * l'environnement sera choisi automatiquement avec l'IP courrante
     */
    'environments_ip' => [
        '127.0.0.1' => 'dev',
        '::1' => 'dev',
        'ip_test' => 'test',
        'ip_prod' => 'prod'
    ]
];