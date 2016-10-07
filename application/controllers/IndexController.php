<?php

class IndexController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (LoginModel::isUserLoggedIn()) {
            Redirect::to('level');
        } else {
            $this->View->render('index/index', array(
                "quizName" => Config::get("QUIZ_NAME")
            ));
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