<?php

namespace PQ\Controllers;

use phpDocumentor\Reflection\DocBlock\Tags\See;
use PQ\Core\Controller;

use PQ\Core\Csrf;
use PQ\Core\Redirect;

use PQ\Core\Session;
use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;

class Login extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            Redirect::to('index');
            return;
        }

        if (LoginModel::isUserLoggedIn()) {
            Redirect::to('index');
        }

        $token = Csrf::generateToken();
        $this->View->render('login/index', array(
            'token' => $token
        ));
    }

    public function action()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            Redirect::to('login');
            return;
        }

        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $token = $_POST['token'];


        if (!Csrf::isTokenValid($token)) {
            Session::add("flash_error", "Failed to login user.");
            Redirect::to('login/index');
            return;
        }

        $login = LoginModel::login($username, $password);
        if (!$login) {
            Redirect::to('login/index');
            return;
        }


        if (UserModel::isAdmin()) {
            Redirect::to('admin/dashboard');
            return;
        }

        $result = UserModel::getUserByUsername($username);
        Redirect::to('level/index/' . $result->level);
        return;
    }

    public function logout()
    {
        LoginModel::logout();
        Redirect::to('index');
        return;
    }
}