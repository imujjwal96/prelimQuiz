<?php


if (!file_exists('../Application/Config/config.php')) {
    header('Location: /install.php');
    die;
}

require '../vendor/autoload.php';
$application = new \Application\Core\Application();