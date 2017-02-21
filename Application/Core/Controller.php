<?php

namespace PQ\Core;

class Controller {

    public $View;
    protected $Session;
    protected $Redirect;
    protected $Config;
    protected $Csrf;
    protected $Files;

    public function __construct() {
        $this->Session = new Session();
        $this->Redirect = new Redirect();
        $this->Config = new Config();
        $this->Csrf = new Csrf();
        $this->Files = new Files();
        $this->Session->init();
        $this->View = new View();
    }
}