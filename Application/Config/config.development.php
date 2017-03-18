<?php

/**
 * This configuration file is only provided to document the different
 * configuration options and their usage.
 *
 * DO NOT COMPLETELY BASE YOUR CONFIGURATION FILE ON THIS SAMPLE. THIS MAY BREAK
 * YOUR INSTANCE. Instead, manually copy configuration switches that you
 * consider important for your instance to your working ``config.php``, and
 * apply configuration options that are pertinent for your instance.
 *
 */
return array(
    /**
     * Configuration for: Base URL
     * This detects your URL/IP incl. sub-folder automatically. You can also deactivate auto-detection and provide the
     * URL manually.
     */
    'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

    /**
     * Configuration for: Folders
     */
    'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/Application/Controllers/',
    'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/Application/Views/',

    /**
     * Configuration for: Default controller and action
     */
    'DEFAULT_CONTROLLER' => 'index',
    'DEFAULT_ACTION' => 'index',



    /**
     * Identifies the database used with this installation. See also config option
     * ``supportedDatabases``
     *
     * Available:
     * 	- mysql (MySQL/MariaDB)
     */
    'DB_TYPE' => "mysql",

    /**
     * Your host server name, for example ``localhost``, ``hostname``,
     * ``hostname.example.com``, or the IP address. To specify a port use
     * ``hostname:####``; to specify a Unix socket use
     * ``localhost:/path/to/socket``.
     */
    'DB_HOST' => '127.0.0.1',

    /**
     * The name of your database, which is set during installation.
     */
    'DB_NAME' => 'prelimquiz',

    /**
     * The user that prelimQuiz uses to write to the database.
     */
    'DB_USER' => '',

    /**
     * The password for the database user.
     */
    'DB_PASS' => '',

    /**
     * The port that the database use.
     */
    'DB_PORT' => 3306,

    /**
     * Character set of the datbase
     */
    'DB_CHARSET' => 'utf8',

    /**
     * Configuration for: Cookies
     */
    'COOKIE_RUNTIME' => 1209600,
    'COOKIE_PATH' => '/',
    'COOKIE_DOMAIN' => "",
    'COOKIE_SECURE' => false,
    'COOKIE_HTTP' => true,
    'SESSION_RUNTIME' => 604800,

    /**
     * Name of the Quiz
     */
    'QUIZ_NAME' => '',

    /**
     * Type of Quiz (MCQ | General | Mixed)
     */
    'QUIZ_TYPE' => "/*Type of Quiz(MCQ/GENERAL/Mixed)*/",


    /**
     * Configuration for: Email server credentials
     *
     * Here you can define how you want to send emails.
     * If you have successfully set up a mail server on your linux server and you know
     * what you do, then you can skip this section. Otherwise please set EMAIL_USE_SMTP to true
     * and fill in your SMTP provider account data.
     *
     * EMAIL_USED_MAILER: Check Mail class for alternatives
     * EMAIL_USE_SMTP: Use SMTP or not
     * EMAIL_SMTP_AUTH: leave this true unless your SMTP service does not need authentication
     */
    'ENABLE_MAIL' => true,
    'EMAIL_USED_MAILER' => 'phpmailer',
    'EMAIL_USE_SMTP' => false,
    'EMAIL_SMTP_AUTH' => '',
    'EMAIL_SMTP_ENCRYPTION' => '',
    'EMAIL_SMTP_HOST' => '',
    'EMAIL_SMTP_USERNAME' => '',
    'EMAIL_SMTP_PASSWORD' => '',
    'EMAIL_SMTP_PORT' => ''
);
