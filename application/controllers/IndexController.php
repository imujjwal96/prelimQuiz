<?php

class IndexController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->View->render('index/index');
    }

    public function instructions() {
        $this->View->render('index/instructions');
    }

}