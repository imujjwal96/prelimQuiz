<?php

namespace PQ\Controllers;

use PQ\Core\Config;
use PQ\Core\Controller;

use PQ\Core\Csrf;
use PQ\Core\Random;
use PQ\Core\Redirect;
use PQ\Core\Request;
use PQ\Core\Session;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Level as LevelModel;
use PQ\Models\Register as RegisterModel;


class Login extends Controller
{
    protected $user;
    protected $login;
    private $Request;
    private $Redirect;
    private $Csrf;

    public function __construct(Config $Config, Csrf $Csrf, Random $Random, Redirect $Redirect, Request $Request, Session $Session, LevelModel $level, LoginModel $login, RegisterModel $register, UserModel $user)
    {
        $this->user = $user;

        $this->Request = $Request;
        $this->Redirect = $Redirect;
        $this->Csrf = $Csrf;

        $this->login = $login;
        $this->user = $user;
        parent::__construct();
    }

    public function index()
    {
        if (!$this->Request->isGet()) {
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
        if (!$this->Request->isPost()) {
            $this->Redirect->to('login');
            return false;
        }

        $username = $this->Request->post('username', true);
        $password = $this->Request->post('password', true);
        $token = $this->Request->post('token', true);


        if (!$this->Csrf->isTokenValid($token)) {
            $this->Session->add("flash_error", "Failed to login user.");
            $this->Redirect->to('login/index');
            return false;
        }

        $login = $this->login->login($username, $password);
        if (!$login) {
            $this->Redirect->to('login/index');
            return false;
        }


        if ($this->user->isAdmin()) {
            $this->Redirect->to('admin/dashboard');
            return true;
        }

        $result = $this->user->getUserByUsername($username);

        $this->Redirect->to('level/index/' . $result->level);
        return true;
    }

    public function logout()
    {
        $this->login->logout();
        $this->Redirect->to('index');
        return true;
    }
}