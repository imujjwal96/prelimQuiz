<?php

class Controller {

    public $View;

    public function __construct() {
        Session::init();

        $this->View = new View();
    }
}