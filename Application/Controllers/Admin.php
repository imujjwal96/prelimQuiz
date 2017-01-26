<?php

namespace PQ\Controllers;

use PQ\Core\Controller;

use PQ\Core\Redirect;
use PQ\Core\Csrf;

use PQ\Core\Session;
use PQ\Models\User as UserModel;
use PQ\Models\Login as LoginModel;
use PQ\Models\Register as RegisterModel;
use PQ\Models\Level as LevelModel;
use PQ\Models\User;

class Admin extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!UserModel::doesUsersExist()) {
            $this->View->render('admin/register', array(
                'token' => Csrf::generateToken()
            ));
            return;
        }

        if (!LoginModel::isUserLoggedIn()) {
            Redirect::to('login');
        }

        if (UserModel::isAdmin()) {
            Redirect::to('admin/dashboard');
        }

        Redirect::to('index');
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->View->renderWithoutHeaderAndFooter('404');
            return;
        }

        $name = strip_tags($_POST['name']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $userName = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $phone = "xxxxxxxxxx";
        $token = strip_tags($_POST['token']);

        if (!(RegisterModel::formValidation($userName, $email) AND Csrf::isTokenValid($token))) {
            Redirect::to("admin");
            return;
        }

        if (UserModel::doesUserExist("email", $email)) {
            Session::add("flash_success", "User with email: " . filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) . " already exists.");
            Redirect::to('admin');
            return;
        }

        RegisterModel::registerNewUser($name, $email, $userName, $phone, $password, 'admin');

        if (LoginModel::login($userName, $password)) {
            Redirect::to('admin/dashboard');
            return;
        }

        Redirect::to("admin");
        return;
    }

    public function dashboard()
    {
        if(!UserModel::doesUsersExist()) {
            Redirect::to("admin");
            return;
        }

        if (LoginModel::isUserLoggedIn() && UserModel::isAdmin()) {
            $this->View->render('admin/dashboard');
            return;
        }
        Redirect::to("index");
        return;
    }

    public function question($action=null, $id=null) {
        if(!UserModel::doesUsersExist()) {
            Redirect::to("admin");
            return;
        }

        if (!(LoginModel::isUserLoggedIn() && UserModel::isAdmin())) {
            Redirect::to("index");
            return;
        }

        if ($id != null && $action=="edit") {
            $question = LevelModel::getQuestionById($id);
            if ($question->type == "MCQ") {
                $this->View->render('admin/questions/edit_mcq', array(
                    "question" => LevelModel::getQuestionById($id)
                ));
                return;
            }
            $this->View->render('admin/questions/edit_general', array(
                "question" => LevelModel::getQuestionById($id)
            ));
            return;
        }

        if ($action == "add") {
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $this->View->render('admin/questions/add', array(
                    "quiz_type" => \PQ\Core\Config::get("QUIZ_TYPE"),
                    "token" => Csrf::generateToken()
                ));
                return;
            }

            if (isset($_POST["mcq"])) {
                if (!isset($_POST["question_statement"], $_POST["option_a"], $_POST["option_b"], $_POST["option_c"],
                    $_POST["option_d"], $_POST["answer"])) {
                    Session::add("flash_error", "Invalid Questions Parameters");
                    Redirect::to('admin/dashboard/add');
                    return;
                }

                $questionStatement = htmlspecialchars($_POST["question_statement"]);
                $questionCover = "";
                if (\PQ\Core\Files::isImage($_FILES["question_cover"])) {
                    $questionCover = $_FILES["question_cover"];
                }
                $optionA = htmlspecialchars($_POST["option_a"]);
                $optionB = htmlspecialchars($_POST["option_b"]);
                $optionC = htmlspecialchars($_POST["option_c"]);
                $optionD = htmlspecialchars($_POST["option_d"]);
                $answer = htmlspecialchars($_POST["answer"]);

                LevelModel::storeMCQQuestion($questionStatement, $questionCover, $optionA, $optionB, $optionC, $optionD, $answer);
                Redirect::to('admin/dashboard');
                return;
            }

            if (isset($_POST["general"])) {
                if (!isset($_POST["question_statement"], $_POST["answer"])) {
                    Session::add("flash_error", "Invalid Questions Parameters");
                    Redirect::to('admin/dashboard/add');
                    return;
                }

                $questionStatement = htmlspecialchars($_POST["question_statement"]);
                $answer = htmlspecialchars($_POST["answer"]);
                $questionCover = "";
                if (\PQ\Core\Files::isImage($_FILES["question_cover"])) {
                    $questionCover = $_FILES["question_cover"];
                }

                LevelModel::storeGeneralQuestion($questionStatement, $questionCover, $answer);
                Redirect::to('admin/dashboard');
                return;
            }

            Session::add("flash_error", "Invalid Question Type");
            Redirect::to("admin/dashboard");
            return;
        }

        if (LevelModel::getTotalQuestions() == 0) {
            Session::add("flash_message", "No questions exist.");
            Redirect::to("admin/dashboard");
            return;
        }

        if ($action == "edit") {
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $this->View->render('admin/questions/edit', array(
                    "questions" => LevelModel::getQuestions(),
                    "token" => Csrf::generateToken()
                ));
                return;
            }

            if (!isset($_POST["question_id"])) {
                Session::add("flash_error", "Invalid question");
                Redirect::to('admin/dashboard/edit');
                return;
            }

            $questionId = htmlspecialchars($_POST["question_id"]);
            Redirect::to('admin/question/edit/' .$questionId);
            return;
        }

        if ($action == "delete") {
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $this->View->render('admin/questions/delete',array(
                    "questions" => LevelModel::getQuestions(),
                    "token" => Csrf::generateToken()
                ));
            }

            if (!isset($_POST["question_id"])) {
                Session::add("flash_error", "Invalid question");
                Redirect::to('admin/dashboard/edit');
                return;
            }

            $questionId = htmlspecialchars($_POST["question_id"]);
            LevelModel::deleteQuestionById($questionId);
            Redirect::to('admin/question/delete');
            return;
        }
    }

    public function instructions() {
        $this->View->render('admin/instructions');
        return;
    }
}