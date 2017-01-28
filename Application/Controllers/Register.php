<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Csrf;
use PQ\Core\Redirect;

use PQ\Core\Session;
use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Register as RegisterModel;

class Register extends Controller 
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

        $this->View->render('register/index', array(
            'token' => Csrf::generateToken()
        ));
        return;
    }

    public function action()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            Redirect::to('index');
            return;
        }
        
        $name = strip_tags($_POST['name']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = strip_tags($_POST['username']);
        $phone = strip_tags($_POST['phone']);
        $password = strip_tags($_POST['password']);
        $token = strip_tags($_POST['token']);

        if (!RegisterModel::formValidation($username, $email) or !Csrf::isTokenValid($token)) {
            echo 'Invalid Credentials';
        }

        if (UserModel::getUserByEmail($email)) {
            Session::add("flash_error", "User with email: " . $email . " already exists.");
            Redirect::to('register');
            return;
        }

        if (UserModel::getUserByUsername($username)) {
            Session::add("flash_error", "User with username: " . $username . " already exists.");
            Redirect::to('register');
            return;
        }

        $register = RegisterModel::registerNewUser($name, $email, $username, $phone, $password);
        if (!$register) {
            Redirect::to('register');
            return;
        }

        if (!LoginModel::login($username, $password)) {
            Redirect::to('login');
            return;
        }

        Redirect::to('level/index/0');
        return;
    }
}