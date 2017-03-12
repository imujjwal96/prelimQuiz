<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Request;
use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;

class Login extends Controller
{
    protected $user;
    protected $login;
    protected $request;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        $this->request = new  Request();

        parent::__construct();
    }

    public function index()
    {
        if (!$this->request->isGet()) {
            $this->Redirect->to('index');
            return;
        }

        if ($this->login->isUserLoggedIn()) {
            $this->Redirect->to('index');
        }

        $this->View->render('login/index');
    }

    public function action()
    {
        if (!$this->request->isPost()) {
            $this->Redirect->to('login');
            return;
        }

        $username = $this->request->post('username', true);
        $password = $this->request->post('password', true);
        $token = $this->request->post('token', true);


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