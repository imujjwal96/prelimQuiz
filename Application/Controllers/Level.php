<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Redirect;

use PQ\Core\Session;
use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Level as LevelModel;

class Level extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($id=null)
    {
        if (!UserModel::doesUsersExist()) {
            Redirect::to('admin');
            return;
        }

        if (!LoginModel::isUserLoggedIn()) {
            Redirect::to('login');
            return;
        }


        $level = LevelModel::getUserLevel();
        if ($id == null) {
            Redirect::to('level/index/' . $level);
            return;
        }

        if ($id != $level) {
            Redirect::to('level/index/'.$level);
            return;
        }

        $question = LevelModel::getCurrentQuestion();
        if (!$question) {
            $this->View->render('level/end');
            return;
        }

        if (LevelModel::getQuestionType() == "MCQ") {
            $this->View->render('level/mcq', array(
                "question" => $question,
                "total" => LevelModel::getTotalQuestions()
            ));
            return;
        }

        $this->View->render('level/general', array(
            "question" => $question,
            "total" => LevelModel::getTotalQuestions()
        ));
        return;
    }

    public function submit()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            Redirect::to('level/index');
            return;
        }

        if (!isset($_POST["input"]) || empty($_POST["input"])) {
            Session::add("flash_message", "Empty input value");
            Redirect::to('level/index');
            return;
        }

        $input = strip_tags($_POST["input"]);
        if (LevelModel::getAnswer() == $input) {
            if (!UserModel::incrementPoints(LevelModel::getQuestionPoints())) {
                echo 'error points';
                exit();
            }
        }
        if (!UserModel::incrementLevel()) {
            echo 'error level';
            exit();
        }
        Redirect::to('level/index');


    }
}