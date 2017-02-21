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
    protected $user;
    protected $login;
    protected $level;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        $this->level = new LevelModel();
        parent::__construct();
    }

    public function index($id=null)
    {
        if (!$this->user->doesUsersExist()) {
            Redirect::to('admin');
            return;
        }

        if (!$this->login->isUserLoggedIn()) {
            Redirect::to('login');
            return;
        }


        $level = $this->level->getUserLevel();
        if ($id == null) {
            Redirect::to('level/index/' . $level);
            return;
        }

        if ($id != $level) {
            Redirect::to('level/index/'.$level);
            return;
        }

        $question = $this->level->getCurrentQuestion();
        if (!$question) {
            $this->View->render('level/end');
            return;
        }

        if ($this->level->getQuestionType() == "MCQ") {
            $this->View->render('level/mcq', array(
                "question" => $question,
                "total" => $this->level->getTotalQuestions()
            ));
            return;
        }

        $this->View->render('level/general', array(
            "question" => $question,
            "total" => $this->level->getTotalQuestions()
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
        if ($this->level->getAnswer() == $input) {
            if (!$this->user->incrementPoints($this->level->getQuestionPoints())) {
                echo 'error points';
                exit();
            }
        }
        if (!$this->user->incrementLevel()) {
            echo 'error level';
            exit();
        }
        Redirect::to('level/index');
    }
}