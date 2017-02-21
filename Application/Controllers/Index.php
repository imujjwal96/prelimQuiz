<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;

class Index extends Controller
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