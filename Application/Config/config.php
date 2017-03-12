<?php
    return array(
        'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

        'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/Application/Controllers/',
        'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/Application/Views/',

        'DEFAULT_CONTROLLER' => 'index',
        'DEFAULT_ACTION' => 'index',

        'DB_TYPE' => "mysql",
        'DB_HOST' => '127.0.0.1',
        'DB_NAME' => "quizrival_db",
        'DB_USER' => "root",
        'DB_PASS' => "qazwsxedc",
        'DB_PORT' => 3306,
        'DB_CHARSET' => 'utf8',

        'COOKIE_RUNTIME' => 1209600,
        'COOKIE_PATH' => '/',
        'COOKIE_DOMAIN' => "",
        'COOKIE_SECURE' => false,
        'COOKIE_HTTP' => true,
        'SESSION_RUNTIME' => 604800,

        'QUIZ_NAME' => "quizrival",
        'QUIZ_TYPE' => "General"
    );
