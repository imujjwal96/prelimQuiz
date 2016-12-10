<?php

namespace Application\Controllers;

use Application\Core\Controller;

use Application\Core\Csrf;
use Application\Core\Redirect;

use Application\Models\User as UserModel;
use Application\Models\Login as LoginModel;

class Login extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (LoginModel::isUserLoggedIn()) {
                Redirect::to('/');
            } else {
                $token = Csrf::generateToken();
                $this->View->render('login/index', array(
                    'token' => $token
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
            $token = $_POST['token'];
            $loginSuccessful = false;
            if (Csrf::isTokenValid($token)) {
                $loginSuccessful = LoginModel::login($userName, $password);
            }
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