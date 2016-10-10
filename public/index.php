<?php


if (!file_exists('../application/config/config.php')) {
    header('Location: /install.php');
    die;
}

require '../vendor/autoload.php';

$application = new Application();