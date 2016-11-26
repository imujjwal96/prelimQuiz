<?php

class LoginController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (LoginModel::isUserLoggedIn()) {
                Redirect::to('/');
            } else {
                $this->View->render('login/index', array(
                    'token' => Csrf::generateToken()
                ));
            }
        } else {
            // error
        }
    }

    public function action() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userName = strip_tags($_POST['username']);
            $password = strip_tags($_POST['password']);
            $token = strip_tags($_POST['token']);

            $loginSuccessful = LoginModel::login($userName, $password);

            if ($loginSuccessful and Csrf::isTokenValid($token)) {
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