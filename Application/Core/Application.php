<?php

namespace PQ\Core;

class Application {

    protected $controller;
    protected $method;
    protected $params = array();
    private $controllerName;
    private $Config;

    public function __construct() {
        $this->Config = new Config();
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
            $this->controller = new $a;

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
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->controllerName = isset($url[0]) ? $url[0] : null;
            $this->method = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $this->params = array_values($url);
        }
    }
}