<?php

namespace PQ\Controllers;

use PQ\Core\Config;
use PQ\Core\Controller;
use PQ\Core\Csrf;
use PQ\Core\Mail;
use PQ\Core\Random;
use PQ\Core\Redirect;
use PQ\Core\Request;

use PQ\Core\Session;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Level as LevelModel;
use PQ\Models\Register as RegisterModel;
use PQ\Models\Token as TokenModel;

class Level extends Controller
{
    protected $user;
    protected $login;
    protected $level;

    private $Csrf;
    private $Redirect;
    private $Request;

    public function __construct(Config $Config, Csrf $Csrf, Mail $Mail, Random $Random, Redirect $Redirect, Request $Request, Session $Session, LevelModel $level, LoginModel $login, RegisterModel $register, UserModel $user, TokenModel $token)
    {
        $this->user = $user;
        $this->login = $login;
        $this->level = $level;

        $this->Csrf = $Csrf;
        $this->Redirect = $Redirect;
        $this->Request = $Request;
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
        if (!$this->Request->isPost()) {
            $this->Redirect->to('level/index');
            return false;
        }

        if (!$this->Request->post('input', true)) {
            $this->Session->add("flash_message", "Empty input value");
            $this->Redirect->to('level/index');
            return false;
        }

        $input = $this->Request->post('input', true);
        $token = $this->Request->post('token');

        if (!$this->Csrf->isTokenValid($token)) {
            $this->Session->add("flash_error", "Failed to login user.");
            $this->Redirect->to('level/index');
            return false;
        }
        if ($this->level->getAnswer() === $input) {
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
        return true;
    }
}