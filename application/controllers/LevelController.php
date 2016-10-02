<?php

class LevelController extends Controller {
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

                    if (LevelModel::getQuestionType() == "MCQ") {
                        $this->View->render('level/mcq', array(
                            "question" => $question
                        ));
                    } else {
                        $this->View->render('level/general', array(
                            "question" => $question
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
            Redirect::to('/level/index');
        } else {
            if (isset($_POST["input"]) AND !empty($_POST["input"])) {
                $input = str_replace(' ', '', strtolower(strip_tags($_POST["input"])));
                if (LevelModel::getAnswer() == $input) {
                    if (!UserModel::incrementPoints(LevelModel::getQuestionPoints())) {
                        echo 'error points';
                        exit();
                    }
                } else{
                    echo $_POST["input"];
                    exit();
                }
                if (!UserModel::incrementLevel()) {
                    echo 'error level';
                    exit();
                }
                Redirect::to('/level/index');
            }
        }
    }
}