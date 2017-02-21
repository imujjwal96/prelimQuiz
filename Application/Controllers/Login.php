<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;

class Login extends Controller
{
    protected $user;
    protected $login;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        parent::__construct();
    }

    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            $this->Redirect->to('index');
            return;
        }

        if ($this->login->isUserLoggedIn()) {
            $this->Redirect->to('index');
        }

        $token = $this->Csrf->generateToken();
        $this->View->render('login/index', array(
            'token' => $token
        ));
    }

    public function action()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->Redirect->to('login');
            return;
        }

        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $token = $_POST['token'];


        if (!$this->Csrf->isTokenValid($token)) {
            $this->Session->add("flash_error", "Failed to login user.");
            $this->Redirect->to('login/index');
            return;
        }

        $login = $this->login->login($username, $password);
        if (!$login) {
            $this->Redirect->to('login/index');
            return;
        }


        if ($this->user->isAdmin()) {
            $this->Redirect->to('admin/dashboard');
            return;
        }

        $result = $this->user->getUserByUsername($username);
        $this->Redirect->to('level/index/' . $result->level);
        return;
    }

    public function logout()
    {
        $this->login->logout();
        $this->Redirect->to('index');
        return;
    }
}