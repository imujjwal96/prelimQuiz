<?php

class LevelController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index($id=null) {
        if (LoginModel::isUserLoggedIn()) {
            $result = UserModel::getUserByUsername(Session::get('user_name'));
            if (!$result) {
                echo 'error';
            } else {
                if ($id == null) {
                    Redirect::to('level/index/' . $result->level);
                } else {
                    if ($id != $result->level) {
                        Redirect::to('level/index/'.$result->level);
                    } else {
                        echo 'You\'re are level: ' . $id;
                    }
                }
            }
        } else {
            echo 'User Not Logged in.';
        }

    }

    public function submit() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            Redirect::to('/level/index');
        }
    }
}