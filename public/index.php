<?php


if (!file_exists('../application/config/config.php')) {
    header('Location: /install.php');
    die;
}

require_once '../application/init.php';

$application = new Application();