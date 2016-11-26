<?php

/**
 * Class Csrf
 * Prevents forms from Cross Site Request Forgery
 */
class Csrf
{
    /**
     * get CSRF token and generate a new one if expire
     * @return string
     */
    public static function generateToken()
    {
        $max_time    = 60 * 60 * 24;
        $stored_time = Session::get('csrf_token_time');
        $csrf_token  = Session::get('csrf_token');

        if ($max_time + $stored_time <= time() || empty($csrf_token)) {

            Session::set('csrf_token', md5(uniqid(rand(), true)));
            Session::set('csrf_token_time', time());
        }
        return Session::get('csrf_token');
    }

    /**
     * checks if CSRF token in session is same as in the form submitted
     * @return bool true if token is valid else false
     */
    public static function isTokenValid($token)
    {
        return $token == Session::get('csrf_token') && !empty($token);
    }
}
