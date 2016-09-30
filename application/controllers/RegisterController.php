<?php

class RegisterController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->View->render('register/index');
        } else {
            // error
        }
    }

    public function action() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = strip_tags($_POST['name']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $userName = strip_tags($_POST['username']);
            $password = strip_tags($_POST['password']);
            $passwordRepeat = strip_tags($_POST['passwordRepeat']);

            if (!RegisterModel::formValidation($userName, $email, $password, $passwordRepeat)) {
                return false;
            }
            if (!UserModel::getUserByEmail($email)) {
                $hash = md5(sha1(md5(sha1($email))));
                $password = password_hash($password, PASSWORD_BCRYPT);

                if (RegisterModel::registerNewUser($name, $email, $userName,  $password)) {
                    $message = 'Registered Successfully';
                    return true;
                } else {
                    $message = 'Error with the database.';
                }
            } else {
                $message = 'User with email: ' . filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) . ' already exists.';
            }

        } else {
            // redirect
        }
        return false;
    }

}