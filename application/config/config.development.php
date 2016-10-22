<?php
    return array(
        'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

        'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/application/controllers/',
        'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/application/views/',

        'DEFAULT_CONTROLLER' => 'index',
        'DEFAULT_ACTION' => 'index',

        'DB_TYPE' => "mysql",
        'DB_HOST' => '127.0.0.1',
        'DB_NAME' => "/*Database Name*/",
        'DB_USER' => "/*Database User*/",
        'DB_PASS' => "/*Database Password*/",
        'DB_PORT' => 3306,
        'DB_CHARSET' => 'utf8',

        'COOKIE_RUNTIME' => 1209600,
        'COOKIE_PATH' => '/',
        'COOKIE_DOMAIN' => "",
        'COOKIE_SECURE' => false,
        'COOKIE_HTTP' => true,
        'SESSION_RUNTIME' => 604800,

        'QUIZ_NAME' => "/*Name of Quiz*/",
        'QUIZ_TYPE' => "/*Type of Quiz(MCQ/GENERAL/Mixed)*/"
    );
