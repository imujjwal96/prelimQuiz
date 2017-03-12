<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Request;
use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Register as RegisterModel;

class Register extends Controller 
{
    protected $user;
    protected $login;
    protected $register;
    protected $request;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        $this->register = new RegisterModel();
        $this->request = new Request();
        parent::__construct();
    }

    public function index() 
    {
        if (!$this->request->isGet()) {
            $this->Redirect->to('index');
            return;
        }

        $this->View->render('register/index');
        return;
    }

    public function action()
    {
        if (!$this->request->isPost()) {
            $this->Redirect->to('index');
            return;
        }
        
        $name = $this->request->post('name', true);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = $this->request->post('username', true);
        $phone = $this->request->post('phone', true);
        $password = $this->request->post('password', true);
        $token = $this->request->post('token', true);

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