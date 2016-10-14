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
            $password = strip_tags($_POST['password']);

            $loginSuccessful = LoginModel::login($userName, $password);

            if ($loginSuccessful) {
                if (UserModel::isAdmin()) {
                    Redirect::to('admin/dashboard');
                } else {
                    $result = UserModel::getUserByUsername($userName);
                    Redirect::to('level/index/'.$result->level);
                }
            } else {
                echo 'Failed to login';
            }

        } else {

        }
    }

    public function logout() {
        LoginModel::logout();
        Redirect::to('index');
        exit();
    }
}