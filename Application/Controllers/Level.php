<?php

namespace PQ\Controllers;

use PQ\Core\Controller;
use PQ\Core\Request;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Level as LevelModel;

class Level extends Controller
{
    protected $user;
    protected $login;
    protected $level;
    protected $request;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        $this->level = new LevelModel();
        $this->request = new Request();
        parent::__construct();
    }

    public function index($id=null)
    {
        if (!$this->user->doesUsersExist()) {
            $this->Redirect->to('admin');
            return;
        }

        if (!$this->login->isUserLoggedIn()) {
            $this->Redirect->to('login');
            return;
        }


        $level = $this->level->getUserLevel();
        if ($id == null) {
            $this->Redirect->to('level/index/' . $level);
            return;
        }

        if ($id != $level) {
            $this->Redirect->to('level/index/'.$level);
            return;
        }

        $question = $this->level->getCurrentQuestion();
        if (!$question) {
            $this->View->render('level/end');
            return;
        }

        if ($this->level->getQuestionType() == "MCQ") {
            $this->View->render('level/mcq', array(
                "user_level" => $this->user->getUserLevel(),
                "question" => $question,
                "total" => $this->level->getTotalQuestions()
            ));
            return;
        }

        $this->View->render('level/general', array(
            "user_level" => $this->user->getUserLevel(),
            "question" => $question,
            "total" => $this->level->getTotalQuestions()
        ));
        return;
    }

    public function submit()
    {
        if (!$this->request->isPost()) {
            $this->Redirect->to('level/index');
            return;
        }

        if (!$this->request->post('input')) {
            $this->Session->add("flash_message", "Empty input value");
            $this->Redirect->to('level/index');
            return;
        }

        $input = $this->request->post('input', true);
        $token = $this->request->post('token');

        if (!$this->Csrf->isTokenValid($token)) {
            $this->Session->add("flash_error", "Failed to login user.");
            $this->Redirect->to('level/index');
            return;
        }
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
        $this->Redirect->to('level/index');
    }
}