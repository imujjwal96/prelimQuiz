<?php

class LoginModel {

    public static function login($userName, $userPhone) {
        if (empty($userName) OR empty($userPhone)) {
            echo 'Empty Credentials';
            return false;
        }

        $result = self::validateAndGetUser($userName, $userPhone);

        if (!$result) {
            return false;
        }

        self::setSuccessfulLoginIntoSession(
            $result->id, $result->username, $result->email
        );

        return true;
    }


    public static function logout() {
        $user_id = Session::get('user_id');

        self::deleteCookie($user_id);

        Session::destroy();
    }

    public static function setSuccessfulLoginIntoSession($userID, $userName, $email) {
        Session::init();

        session_regenerate_id(true);
        $_SESSION = array();

        Session::set('user_id', $userID);
        Session::set('user_name', $userName);
        Session::set('user_email', $email);

        Session::set('user_logged_in', true);

        setcookie(session_name(), session_id(), time() + Config::get('SESSION_RUNTIME'), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));

    }

    public static function isUserLoggedIn() {
        return Session::userIsLoggedIn();
    }

    public static function deleteCookie($userID = null) {
        setcookie('remember_me', false, time() - (3600 * 24 * 3650), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

    private static function validateAndGetUser($userName, $userPhone)
    {

        $result = UserModel::getUserByUsername($userName);

        if (!$result) {
            echo 'User not Found';
            return false;
        }

        // if hash of provided password does NOT match the hash in the database: +1 failed-login counter
        if (strcmp($userPhone, $result->phone) != 0) {
            echo 'Phone number didn\'t match';
            return false;
        }

        return $result;
    }

}