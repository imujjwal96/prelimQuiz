<?php

namespace PQ\Controllers;

use PQ\Core\Controller;
use PQ\Core\Request;

use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Register as RegisterModel;
use PQ\Models\Level as LevelModel;

class Admin extends Controller
{
    protected $user;
    protected $login;
    protected $register;
    protected $level;
    protected $request;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new LoginModel();
        $this->register = new RegisterModel();
        $this->level = new LevelModel();
        $this->request = new Request();
        parent::__construct();
    }

    public function index()
    {
        if (!$this->user->doesUsersExist()) {
            $this->View->render('admin/register');
            return;
        }

        if (!$this->login->isUserLoggedIn()) {
            $this->Redirect->to('login');
            return;
        }

        if ($this->user->isAdmin()) {
            $this->Redirect->to('admin/dashboard');
            return;
        }

        $this->Redirect->to('index');
        return;
    }

    public function register()
    {
        if (!$this->request->isPost()) {
            $this->Redirect->to('index');
            return;
        }

        $name = $this->request->post('name', true);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = $this->request->post('username', true);
        $password = $this->request->post('password', true);
        $phone = "xxxxxxxxxx";
        $token = $this->request->post('token', true);

        if (!($this->register->formValidation($username, $email) AND $this->Csrf->isTokenValid($token))) {
            $this->Redirect->to("admin");
            return;
        }

        if ($this->user->doesUserExist("email", $email)) {
            $this->Session->add("flash_error", "User with email: " . filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) . " already exists.");
            $this->Redirect->to('admin');
            return;
        }

        $this->register->registerNewUser($name, $email, $username, $phone, $password, 'admin');

        if ($this->login->login($username, $password)) {
            $this->Redirect->to('admin/dashboard');
            return;
        }

        $this->Redirect->to('admin');
        return;
    }

    public function dashboard()
    {
        if(!$this->user->doesUsersExist()) {
            $this->Redirect->to('admin');
            return;
        }

        if (!$this->login->isUserLoggedIn()) {
            $this->Redirect->to('index');
            return;
        }

        if (!$this->user->isAdmin()) {
            $this->Redirect->to('index');
            return;
        }

        $this->View->render('admin/dashboard');
        return;
    }

    public function question($action=null, $id=null) {
        if(!$this->user->doesUsersExist()) {
            $this->Redirect->to("admin");
            return;
        }

        if (!$this->login->isUserLoggedIn()) {
            $this->Redirect->to('index');
            return;
        }

        if (!$this->user->isAdmin()) {
            $this->Redirect->to('index');
            return;
        }

        if ($id != null && $action=="edit") {
            $question = $this->level->getQuestionById($id);
            if ($question->type == "MCQ") {
                $this->View->render('admin/questions/edit_mcq', array(
                    "question" => $question
                ));
                return;
            }
            $this->View->render('admin/questions/edit_general', array(
                "question" => $question
            ));
            return;
        }

        if ($action == "add") {
            if (!$this->request->isPost()) {
                $this->View->render('admin/questions/add', array(
                    "quiz_type" => $this->Config->get("QUIZ_TYPE")
                ));
                return;
            }

            if ($this->request->post('mcq')) {
                if (!($this->request->post('question_statement') && $this->request->post('option_a') && $this->request->post('option_b') &&
                     $this->request->post('option_c') && $this->request->post('option_d') && $this->request->post('answer'))) {
                    $this->Session->add("flash_error", "Invalid Questions Parameters");
                    $this->Redirect->to('admin/dashboard/add');
                    return;
                }

                $questionStatement = htmlspecialchars($this->request->post('question_statement'));
                $questionCover = "";
                if ($this->Files->isImage($_FILES["question_cover"])) {
                    $questionCover = $_FILES["question_cover"];
                }
                $optionA = htmlspecialchars($this->request->post('option_a'), true);
                $optionB = htmlspecialchars($this->request->post('option_b'), true);
                $optionC = htmlspecialchars($this->request->post('option_c'), true);
                $optionD = htmlspecialchars($this->request->post('option_d'), true);
                $answer = htmlspecialchars($this->request->post('answer'), true);
                $token = $this->request->post('token');

                if (!$this->Csrf->isTokenValid($token)) {
                    $this->Session->add("flash_error", "Failed to add question.");
                    $this->Redirect->to('admin/dashboard');
                    return;
                }

                $this->level->storeMCQQuestion($questionStatement, $questionCover, $optionA, $optionB, $optionC, $optionD, $answer);
                $this->Redirect->to('admin/dashboard');
                return;
            }

            if ($this->request->post('general')) {
                if (!($this->request->post('question_statement') && $this->request->post('answer'))) {
                    $this->Session->add("flash_error", "Invalid Questions Parameters");
                    $this->Redirect->to('admin/dashboard/add');
                    return;
                }

                $questionStatement = htmlspecialchars($this->request->post('question_statement', true));
                $answer = htmlspecialchars($this->request->post('answer'));
                $token = $this->request->post('token');

                if (!$this->Csrf->isTokenValid($token)) {
                    $this->Session->add("flash_error", "Failed to add question.");
                    $this->Redirect->to('admin/dashboard');
                    return;
                }

                $questionCover = "";
                if ($this->Files->isImage($_FILES["question_cover"])) {
                    $questionCover = $_FILES["question_cover"];
                }

                $this->level->storeGeneralQuestion($questionStatement, $questionCover, $answer);
                $this->Redirect->to('admin/dashboard');
                return;
            }

            $this->Session->add("flash_error", "Invalid Question Type");
            $this->Redirect->to("admin/dashboard");
            return;
        }

        if ($this->level->getTotalQuestions() == 0) {
            $this->Session->add("flash_message", "No questions exist.");
            $this->Redirect->to("admin/dashboard");
            return;
        }

        if ($action == "edit") {
            if (!$this->request->isPost()) {
                $this->View->render('admin/questions/edit', array(
                    "questions" => $this->level->getQuestions()
                ));
                return;
            }

            if (!$this->request->post('question_id')) {
                $this->Session->add("flash_error", "Invalid question");
                $this->Redirect->to('admin/dashboard/edit');
                return;
            }

            $questionId = htmlspecialchars($this->request->post('question_id'));
            $token = $this->request->post('token');

            if (!$this->Csrf->isTokenValid($token)) {
                $this->Session->add("flash_error", "Failed to edit question.");
                $this->Redirect->to('login/index');
                return;
            }
            $this->Redirect->to('admin/question/edit/' .$questionId);
            return;
        }

        if ($action == "delete") {
            if (!$this->request->isPost()) {
                $this->View->render('admin/questions/delete',array(
                    "questions" => $this->level->getQuestions()
                ));
            }

            if (!$this->request->post('question_id')) {
                $this->Session->add("flash_error", "Invalid question");
                $this->Redirect->to('admin/dashboard/edit');
                return;
            }

            $questionId = htmlspecialchars($this->request->post('question_id'), true);
            $token = $this->request->post('token');
            if (!$this->Csrf->isTokenValid($token)) {
                $this->Session->add("flash_error", "Failed to delete question.");
                $this->Redirect->to('admin/question/delete');
                return;
            }
            $this->level->deleteQuestionById($questionId);
            $this->Redirect->to('admin/question/delete');
            return;
        }
    }

    public function instructions()
    {
        $this->View->render('admin/instructions');
        return;
    }
}