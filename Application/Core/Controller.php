<?php

namespace PQ\Core;

class Controller {

    public $View;
    protected $Session;
    protected $Files;

    public function __construct() {
        $this->Session = new Session();
        $this->Files = new Files();
        $this->Session->init();
        $this->View = new View();
    }
}