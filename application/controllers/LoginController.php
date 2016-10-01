<?php

class LoginController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->View->render('login/index');

        } else {
            // error
        }
    }

    public function action() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userName = strip_tags($_POST['username']);
            $phone = strip_tags($_POST['phone']);

            $loginSuccessful = LoginModel::login($userName, $phone);

            if ($loginSuccessful) {
                $result = UserModel::getUserByUsername($userName);
                Redirect::to('level/index/'.$result->level);
            } else {
                echo 'Failed to login';
            }

        } else {

        }
    }
}