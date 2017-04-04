<?php

namespace PQ\Core;

use PQ\Models\Level;
use PQ\Models\Login;
use PQ\Models\Register;
use PQ\Models\Token;
use PQ\Models\User;

class Application {

    protected $controller;
    protected $method;
    protected $params = array();
    private $controllerName;

    private $Config;
    private $Csrf;
    private $Random;
    private $Redirect;
    private $Request;
    private $Session;

    private $level;
    private $login;
    private $register;
    private $user;
    private $token;

    public function __construct() {
        $this->Config = new Config();
        $this->Csrf = new Csrf();
        $this->Random = new Random();
        $this->Redirect = new Redirect();
        $this->Request = new Request();
        $this->Session = new Session();
        $this->Mail = new Mail();

        $this->level = new Level();
        $this->login = new Login();
        $this->register = new Register();
        $this->user = new User();
        $this->token = new Token();

        $this->parseURL();

        if (!$this->controllerName) {
            $this->controllerName = $this->Config->get('DEFAULT_CONTROLLER');
        }

        if (!$this->method OR (strlen($this->method) == 0)) {
            $this->method = $this->Config->get('DEFAULT_ACTION');
        }

        $this->controllerName = ucwords($this->controllerName);

        if (file_exists($this->Config->get('PATH_CONTROLLER') . $this->controllerName . '.php')) {

            require $this->Config->get('PATH_CONTROLLER') . $this->controllerName . '.php';
            $a = 'PQ\Controllers\\' . $this->controllerName;
            $this->controller = new $a(
                $this->Config,
                $this->Csrf,
                $this->Mail,
                $this->Random,
                $this->Redirect,
                $this->Request,
                $this->Session,

                $this->level,
                $this->login,
                $this->register,
                $this->user,
                $this->token
            );

            if (method_exists($this->controller, $this->method)) {
                if (!empty($this->params)) {
                    call_user_func_array(array($this->controller, $this->method), $this->params);
                } else {
                    $this->controller->{$this->method}();
                }
            } else {
                require $this->Config->get('PATH_VIEW') . '404.php';
            }
        } else {
            require $this->Config->get('PATH_VIEW') . '404.php';
        }
    }

    public function parseURL() {
        if ($this->Request->get('url')) {
            $url = trim($this->Request->get('url'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->controllerName = isset($url[0]) ? $url[0] : null;
            $this->method = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $this->params = array_values($url);
        }
    }
}