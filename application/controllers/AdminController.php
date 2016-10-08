<?php

class AdminController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (!UserModel::doesUsersExist()) {
            $this->View->render('admin/register');
        } else {
            // Check if Logged in
            // If not logged in, login page
        }
    }

    public function regiser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        } else {
            $this->View->renderWithoutHeaderAndFooter('404.php');
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        } else {
            // Check if logged in

            //if not logged in
            $this->View->render('admin/login');
        }
    }
}