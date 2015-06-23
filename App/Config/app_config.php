<?php

return [
    'name' => 'Titre de mon site',
    'default_action' => 'index',
    'default_controller' => 'home',
    'prefixes' => ['admin', 'user'],
    'languages' => ['Fr', 'En', 'Es'],
    'environments_ip' => [
        '127.0.0.1' => 'dev',
        'ip_test' => 'test',
        'ip_prod' => 'prod'
    ]
];