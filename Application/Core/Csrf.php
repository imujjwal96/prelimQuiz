<?php

namespace PQ\Core;

/**
 * Class Csrf
 * Prevents forms from Cross Site Request Forgery
 */
class Csrf
{
    private $Session;

    public function __construct()
    {
        $this->Session = new Session();
    }

    /**
     * get CSRF token and generate a new one if expire
     * @return string
     */
    public function generateToken()
    {
        $max_time    = 60 * 60 * 24;
        $stored_time = $this->Session->get('csrf_token_time');
        $csrf_token  = $this->Session->get('csrf_token');

        if (((int)$max_time + (int)$stored_time) <= time() || empty($csrf_token)) {

            $this->Session->set('csrf_token', md5(uniqid(rand(), true)));
            $this->Session->set('csrf_token_time', time());
        }
        return $this->Session->get('csrf_token');
    }

    /**
     * checks if CSRF token in session is same as in the form submitted
     * @return bool true if token is valid else false
     */
    public function isTokenValid($token)
    {
        return $token == $this->Session->get('csrf_token') && !empty($token);
    }
}
