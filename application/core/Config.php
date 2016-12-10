<?php

namespace Application\Core;

class Config {
    public static $config;

    public static function get($key)
    {
        if (!self::$config) {

            $config_file = '../application/config/config.php';

            if (!file_exists($config_file)) {
                return false;
            }

            self::$config = require $config_file;
        }

        return self::$config[$key];
    }
}