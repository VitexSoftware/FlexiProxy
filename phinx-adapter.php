<?php

namespace FlexiProxy;

include_once './vendor/autoload.php';

$flexi = new FlexiProxy(null, ['confdir' => realpath('src')]);

return array('environments' =>
    array(
        'default_database' => 'development',
        'development' => array(
            'name' => 'phinx',
            'connection' => \Ease\Shared::db()->sqlLink
        ),
        'default_database' => 'production',
        'production' => array(
            'name' => 'phinx',
            'connection' => \Ease\Shared::db()->sqlLink
        ),
    ),
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds' => 'db/seeds'
    ]
);
