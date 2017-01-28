<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Redirect;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!UserModel::doesUserExist()) {
            Redirect::to('admin');
            return;
        }

        if (!LoginModel::isUserLoggedIn()) {
            $this->View->render('index/index', array(
                "quizName" => \PQ\Core\Config::get("QUIZ_NAME")
            ));
            return;
        }

        if (UserModel::isAdmin()) {
            Redirect::to('admin/dashboard');
            return;
        }

        Redirect::to('level');
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
            'users' => UserModel::getUsersByPoints()
        ));
        return;
    }
}