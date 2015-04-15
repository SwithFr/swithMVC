<?php

return [
    'name' => 'Titre de mon site',
    'default_action' => 'index',
    'default_controller' => 'controller',
    'prefixes' => ['admin', 'user'],
    'environments_ip' => [
        '127.0.0.1' => 'dev',
        'ip_test' => 'test',
        'ip_prod' => 'prod'
    ]
];