<?php

namespace Application\Controllers;

use Application\Core\Controller;

use Application\Core\Redirect;
use Application\Core\Csrf;

use Application\Models\User as UserModel;
use Application\Models\Login as LoginModel;
use Application\Models\Register as RegisterModel;
use Application\Models\Level as LevelModel;

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
        if (LoginModel::isUserLoggedIn() && UserModel::isAdmin()) {
            Redirect::to('/admin/dashboard');
        } elseif (!LoginModel::isUserLoggedIn()) {
            Redirect::to('/login');
        } else {
            Redirect::to('/index');
        }
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

        if (!RegisterModel::formValidation($userName, $email) or !Csrf::isTokenValid($token)) {
            echo 'Invalid Credentials';
            return;
        }

        if (!UserModel::getUserByEmail($email)) {
            if (RegisterModel::registerNewUser($name, $email, $userName, $phone, $password, 'admin')) {
                if (LoginModel::login($userName, $password)) {
                    Redirect::to('admin/dashboard');
                }
                echo 'Registered Successfully';
            } else {
                echo 'Error with the DB';
            }
        } else {
            echo 'User with email: ' . filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) . ' already exists.';
        }
    }

    public function dashboard()
    {
        if (LoginModel::isUserLoggedIn() && UserModel::isAdmin()) {
            $this->View->render('admin/dashboard');
        }
    }

    public function question($action=null, $id=null) {
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
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $this->View->render('admin/questions/add', array(
                    "quiz_type" => \Application\Core\Config::get("QUIZ_TYPE"),
                    "token" => Csrf::generateToken()
                ));
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["mcq"])) {
                    if (isset($_POST["question_statement"], $_POST["option_a"], $_POST["option_b"], $_POST["option_c"],
                        $_POST["option_d"], $_POST["answer"])) {
                        $questionStatement = htmlspecialchars($_POST["question_statement"]);
                        $questionCover = "";
                        if (\Application\Core\Files::isImage($_FILES["question_cover"])) {
                            $questionCover = $_FILES["question_cover"];
                        }
                        $optionA = htmlspecialchars($_POST["option_a"]);
                        $optionB = htmlspecialchars($_POST["option_b"]);
                        $optionC = htmlspecialchars($_POST["option_c"]);
                        $optionD = htmlspecialchars($_POST["option_d"]);
                        $answer = htmlspecialchars($_POST["answer"]);

                        if (LevelModel::storeMCQQuestion($questionStatement, $questionCover, $optionA, $optionB, $optionC, $optionD, $answer)) {
                            Redirect::to('/admin/dashboard');
                        } else {
                            echo 'Could not store the question.';
                        }
                    }
                } elseif (isset($_POST["general"])) {
                    if (isset($_POST["question_statement"], $_POST["answer"])) {
                        $questionStatement = htmlspecialchars($_POST["question_statement"]);
                        $answer = htmlspecialchars($_POST["answer"]);
                        $questionCover = "";
                        if (\Application\Core\Files::isImage($_FILES["question_cover"])) {
                            $questionCover = $_FILES["question_cover"];
                        }

                        if (LevelModel::storeGeneralQuestion($questionStatement, $questionCover, $answer)) {
                            Redirect::to('/admin/dashboard');
                        } else {
                            echo 'Could not store the question.';
                        }
                    }
                } else {

                }
            }
        } else {
            if (LevelModel::getTotalQuestions() != 0) {
                if ($action == "edit") {
                    if ($_SERVER["REQUEST_METHOD"] != "POST") {
                        $this->View->render('admin/questions/edit', array(
                            "questions" => LevelModel::getQuestions(),
                            "token" => Csrf::generateToken()
                        ));
                        return;
                    }

                    if (isset($_POST["question_id"])) {
                        $questionId = htmlspecialchars($_POST["question_id"]);
                        Redirect::to('admin/question/edit/' .$questionId);
                    }
                } elseif ($action == "delete") {
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        $this->View->render('admin/questions/delete',array(
                            "questions" => LevelModel::getQuestions(),
                            "token" => Csrf::generateToken()
                        ));
                    } else {
                        if (isset($_POST["question_id"])) {
                            $questionId = htmlspecialchars($_POST["question_id"]);
                            LevelModel::deleteQuestionById($questionId);
                            Redirect::to('admin/question/delete');
                        }
                    }

                }
            } else {
                echo 'No Questions Exist';
            }
        }
    }

    public function instructions() {
        $this->View->render('admin/instructions');
    }
}