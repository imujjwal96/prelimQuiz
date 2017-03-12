<?php

namespace PQ\Core;

class Random {

    const CHAR_UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const CHAR_LOWER = 'abcdefghijklmnopqrstuvwxyz';
    const CHAR_DIGITS = '0123456789';
    const CHAR_SYMBOLS = '!\"#$%&\\\'()* +,-./:;<=>?@[\]^_`{|}~';

    /**
     * Generate a random string of specified length
     *
     * @param integer $length
     * @param string $characters
     * @return string
     */
    public function generate($length, $characters = self::CHAR_UPPER . self::CHAR_LOWER . self::CHAR_DIGITS) {
        $maxCharIndex = strlen($characters) - 1;
        $randomString = '';

        while($length > 0) {
            $randomNumber = \random_int(0, $maxCharIndex);
            $randomString .= $characters[$randomNumber];
            $length--;
        }
        return $randomString;
    }
}