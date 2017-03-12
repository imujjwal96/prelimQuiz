<?php

namespace PQ\Core;

/**
 * Class Csrf
 * Prevents forms from Cross Site Request Forgery
 */
class Csrf {

    private $Session;
    private $Random;

    public function __construct() {
        $this->Session = new Session();
        $this->Random = new Random();
    }

    public function getToken() {
        if($this->hasToken()) {
            $value = $this->Session->get('csrf_token');
        } else {
            $value = $this->Random->generate(32);
            $this->setToken($value);
        }

        return $value;
    }


    public function setToken($value) {
        $this->Session->set('csrf_token', $value);
    }

    public function refreshToken() {
        $value = $this->Random->generate(32);
        $this->setToken($value);
        return $value;
    }

    public function removeToken() {
        $this->Session->remove('csrt_token');
    }

    public function hasToken() {
        return $this->Session->exists('csrf_token');
    }

    public function isTokenValid($token) {
        if(!$this->hasToken()) {
            return false;
        }

        return hash_equals($this->getToken(),$this->decrypt($token));
    }

    public function encrypt($token) {
        $sharedSecret = base64_encode(random_bytes(strlen($token)));
        return base64_encode($token ^ $sharedSecret) .':'.$sharedSecret;
    }

    public function decrypt($encrypted) {
        $token = explode(':', $encrypted);
        if (count($token) !== 2) {
            return '';
        }
        $obfuscatedToken = $token[0];
        $secret = $token[1];
        return base64_decode($obfuscatedToken) ^ $secret;
    }
}
