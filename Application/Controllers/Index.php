<?php

namespace PQ\Controllers;

use PQ\Core\Config;
use PQ\Core\Controller;

use PQ\Core\Csrf;
use PQ\Core\Mail;
use PQ\Core\Random;
use PQ\Core\Redirect;
use PQ\Core\Request;
use PQ\Core\Session;

use PQ\Models\Level as LevelModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Register as RegisterModel;
use PQ\Models\User as UserModel;
use PQ\Models\Token as TokenModel;

class Index extends Controller
{
    protected $user;
    protected $login;

    private $Config;
    private $Redirect;

    public function __construct(Config $Config, Csrf $Csrf, Mail $Mail, Random $Random, Redirect $Redirect, Request $Request, Session $Session, LevelModel $level, LoginModel $login, RegisterModel $register, UserModel $user, TokenModel $token)
    {
        $this->user = $user;
        $this->login = $login;

        $this->Config = $Config;
        $this->Redirect = $Redirect;
        parent::__construct();
    }

    public function index()
    {
        if (!$this->user->doesUsersExist()) {
            $this->Redirect->to('admin');
            return;
        }

        if (!$this->login->isUserLoggedIn()) {
            $this->View->render('index/index', array(
                "quizName" => $this->Config->get("QUIZ_NAME")
            ));
            return;
        }

        if ($this->user->isAdmin()) {
            $this->Redirect->to('admin/dashboard');
            return;
        }

        $this->Redirect->to('level');
        return;
    }

    public function instructions()
    {
        $this->View->render('index/instructions');
        return;
    }

    public function leaderboard()
    {
        $this->View->render('index/leaderboard', array(
            'users' => $this->user->getUsersByPoints()
        ));
        return;
    }
}