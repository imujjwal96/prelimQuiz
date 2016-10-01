<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

return array(
    'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

    'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/application/controllers/',
    'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/application/views/',

    'DEFAULT_CONTROLLER' => 'index',
    'DEFAULT_ACTION' => 'index',

    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'prelim_quiz',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_PORT' => '3306',
    'DB_CHARSET' => 'utf8',

    'COOKIE_RUNTIME' => 1209600,
    'COOKIE_PATH' => '/',
    'COOKIE_DOMAIN' => "",
    'COOKIE_SECURE' => false,
    'COOKIE_HTTP' => true,
    'SESSION_RUNTIME' => 604800
);