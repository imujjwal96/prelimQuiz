<?php
class Session {
	public static function init() {
		if (session_id () == '') {
			session_start ();
			// Each Session receive token
			$this->token = uniqid ( rand (), true );
			// Store tokens in sessions
			$_SESSION ['token'] = $token;
			// And Store timestamps of creations
			$_SESSION ['token_time'] = time ();
		}
	}
	public static function set($key, $value) {
		$_SESSION [$key] = $value;
	}
	public static function get($key) {
		if (isset ( $_SESSION [$key] )) {
			$value = $_SESSION [$key];
			
			return $value;
		}
	}
	public static function add($key, $value) {
		$_SESSION [$key] [] = $value;
	}
	public static function destroy() {
		session_destroy ();
	}
	public static function userIsLoggedIn() {
		return (self::get ( 'user_logged_in' ) ? true : false);
	}
}