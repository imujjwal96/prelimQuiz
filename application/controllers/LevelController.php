<?php

class LevelController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index($id) {
        echo 'Level: '. $id;
    }
}