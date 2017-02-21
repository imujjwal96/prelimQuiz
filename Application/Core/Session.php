<?php

namespace PQ\Core;

class Session {
    public function init() {
        if (session_id() == '') {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];

            return $value;
        }
        return '';
    }

    public function add($key, $value) {
        $_SESSION[$key][] = $value;
    }

    public function destroy() {
        session_destroy();
    }

    public function userIsLoggedIn() {
        return (self::get('user_logged_in') ? true : false);
    }
}