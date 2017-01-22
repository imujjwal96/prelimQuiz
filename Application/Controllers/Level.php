<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Redirect;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Level as LevelModel;

class Level extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index($id=null) {
        if (LoginModel::isUserLoggedIn()) {
            $level = LevelModel::getUserLevel();
            if ($id == null) {
                Redirect::to('level/index/' . $level);
            } else {
                if ($id != $level) {
                    Redirect::to('level/index/'.$level);
                } else {

                    $question = LevelModel::getCurrentQuestion();
                    if (!$question) {
                        $this->View->render('level/end');
                        exit();
                    }
                    if (LevelModel::getQuestionType() == "MCQ") {
                        $this->View->render('level/mcq', array(
                            "question" => $question,
                            "total" => LevelModel::getTotalQuestions()
                        ));
                    } else {

                        $this->View->render('level/general', array(
                            "question" => $question,
                            "total" => LevelModel::getTotalQuestions()
                        ));
                    }

                }
            }
        } else {
            echo 'User Not Logged in.';
        }

    }

    public function submit() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            Redirect::to('level/index');
        } else {
            if (isset($_POST["input"]) AND !empty($_POST["input"])) {
                $input = htmlspecialchars($_POST["input"]);
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
            } else {
                Redirect::to('level/index');
            }
        }
    }
}