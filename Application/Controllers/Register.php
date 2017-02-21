<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Register as RegisterModel;

class Register extends Controller 
{
    protected $user;
    protected $login;
    protected $register;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        $this->register = new RegisterModel();
        parent::__construct();
    }

    public function index() 
    {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            $this->Redirect->to('index');
            return;
        }

        $this->View->render('register/index', array(
            'token' => $this->Csrf->generateToken()
        ));
        return;
    }

    public function action()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->Redirect->to('index');
            return;
        }
        
        $name = strip_tags($_POST['name']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = strip_tags($_POST['username']);
        $phone = strip_tags($_POST['phone']);
        $password = strip_tags($_POST['password']);
        $token = strip_tags($_POST['token']);

        if (!$this->register->formValidation($username, $email) or !$this->Csrf->isTokenValid($token)) {
            echo 'Invalid Credentials';
        }

        if ($this->user->getUserByEmail($email)) {
            $this->Session->add("flash_error", "User with email: " . $email . " already exists.");
            $this->Redirect->to('register');
            return;
        }

        if ($this->user->getUserByUsername($username)) {
            $this->Session->add("flash_error", "User with username: " . $username . " already exists.");
            $this->Redirect->to('register');
            return;
        }

        $register = $this->register->registerNewUser($name, $email, $username, $phone, $password);
        if (!$register) {
            $this->Redirect->to('register');
            return;
        }

        if (!$this->login->login($username, $password)) {
            $this->Redirect->to('login');
            return;
        }

        $this->Redirect->to('level/index/0');
        return;
    }
}