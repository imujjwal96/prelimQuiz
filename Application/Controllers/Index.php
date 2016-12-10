<?php

namespace Application\Controllers;

use Application\Core\Controller;

use Application\Core\Redirect;

use Application\Models\User as UserModel;
use Application\Models\Login as LoginModel;

class Index extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (LoginModel::isUserLoggedIn()) {
            if (UserModel::isAdmin()) {
                Redirect::to('admin/dashboard');
            } else {
                Redirect::to('level');
            }
        } else {
            if (UserModel::doesUsersExist()) {
                $this->View->render('index/index', array(
                    "quizName" => \Application\Core\Config::get("QUIZ_NAME")
                ));
            } else {
                Redirect::to('admin');
            }

        }
    }

    public function instructions() {
        $this->View->render('index/instructions');
    }

    public function leaderboard() {
        $this->View->render('index/leaderboard', array(
            'users' => UserModel::getUsersByPoints()
        ));
    }
}