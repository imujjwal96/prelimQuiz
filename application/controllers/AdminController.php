<?php

class AdminController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!UserModel::doesUsersExist()) {
            $this->View->render('admin/register');
        } else {
            // Check if Logged in
            // If not logged in, login page
        }
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = strip_tags($_POST['name']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $userName = strip_tags($_POST['username']);
            $phone = strip_tags($_POST['phone']);

            if (!RegisterModel::formValidation($userName, $email)) {
                echo 'Invalid Credentials';
            }
            if (!UserModel::getUserByEmail($email)) {
                if (RegisterModel::registerNewUser($name, $email, $userName, $phone, 'admin')) {
                    if (LoginModel::login($userName, $phone)) {
                        Redirect::to('admin/dashboard');
                    }
                    echo 'Registered Successfully';
                } else {
                    echo 'Error with the DB';
                }
            } else {
                echo 'User with email: ' . filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) . ' already exists.';
            }

        } else {
            $this->View->renderWithoutHeaderAndFooter('404.php');
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        } else {
            // Check if logged in

            //if not logged in
            $this->View->render('admin/login');
        }
    }

    public function dashboard()
    {
        if (LoginModel::isUserLoggedIn() && UserModel::isAdmin()) {
            $this->View->render('admin/dashboard');
        }
    }
}