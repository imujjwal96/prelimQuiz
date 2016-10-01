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

                    echo 'You\'re are level: ' . $id . '<br />';

                    $question = LevelModel::getCurrentQuestion();
                    echo $question->statement. '<br />';
                    echo $question->options->a. '<br />';
                    echo $question->options->b. '<br />';
                    echo $question->options->c. '<br />';
                    echo $question->options->d. '<br />';
                }
            }
        } else {
            echo 'User Not Logged in.';
        }

    }

    public function submit() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            Redirect::to('/level/index');
        }
    }
}