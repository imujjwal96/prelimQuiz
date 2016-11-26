<?php

/**
 * Class LoginModel
 * Handles user login
 */
class LoginModel {

    /**
     * Login a user
     * @param string $userName. User's username
     * @param string $userPassword. User's password
     * @return bool true if user successfully logged in, else false
     */
    public static function login($userName, $userPassword) {
        if (empty($userName) OR empty($userPassword)) {
            echo 'Empty Credentials';
            return false;
        }

        $result = self::validateAndGetUser($userName, $userPassword);

        if (!$result) {
            return false;
        }

        self::setSuccessfulLoginIntoSession(
            $result->id, $result->username, $result->email
        );

        return true;
    }

    /**
     * Logs out a user
     */
    public static function logout() {
        $user_id = Session::get('user_id');

        self::deleteCookie($user_id);

        Session::destroy();
    }

    /**
     * Sets user credentials into session
     * @param int $userID. User's id
     * @param string $userName. User's username
     * @param string $email. User's email
     */
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

    /**
     * Checks if a user is logged in
     * @return bool true if the uer is logged in, else false
     */
    public static function isUserLoggedIn() {
        return Session::userIsLoggedIn();
    }

    /**
     * Deletes the cookie
     * @param int/null $userID
     */
    public static function deleteCookie($userID = null) {
        setcookie('remember_me', false, time() - (3600 * 24 * 3650), Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'), Config::get('COOKIE_SECURE'), Config::get('COOKIE_HTTP'));
    }

    /**
     * Validates the user credentials and get user info
     * @param string $userName. User's username
     * @param string $userpa. User's phone number
     * @return bool|mixed User object if the credentials are correct, else returns false
     */
    private static function validateAndGetUser($userName, $userPassword)
    {

        $result = UserModel::getUserByUsername($userName);

        if (!$result) {
            echo 'User not Found';
            return false;
        }

        if (!password_verify($userPassword, $result->password)) {
            return false;
        }

        return $result;
    }
}