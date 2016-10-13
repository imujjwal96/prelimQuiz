<?php

/**
 * Class RegisterModel
 * Handles user registration
 */
class RegisterModel {

    /**
     * Registers a user
     * @param string $name. User's name
     * @param string $email. User's email
     * @param string $userName. User's username
     * @param string $phone. User's phone number
     * @param string $role. User's role (admin / contestant)
     * @return bool true if user registered successfully, else false
     */
    public static function registerNewUser($name, $email, $userName,  $phone, $role = 'contestant') {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO info (name, email, username, phone, points, level, role, datetime) VALUES (:name, :email, :username, :phone, '0', '0', :role, NOW())";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':name' => $name,
            ':email' => $email,
            ':username' => $userName,
            ':phone' => $phone,
            ':role' => $role
            ));

        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    /**
     * Validates form inputs
     * @param string $userName. User's username
     * @param string $email. User's email
     * @return bool true if credentials are validated, else false
     */
    public static function formValidation($userName, $email) {
        if (self::validateUserName($userName) AND self::validateEmail($email)) {
            return true;
        }
        return false;
    }

    /**
     * Validates a user's username
     * @param string $userName. User's username
     * @return bool true if username is validated, else false
     * Username should contain only alphanumeric characters of length in between 2 and 64
     */
    public static function validateUserName($userName) {
        if (empty($userName)) {
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9]{2,64}$/', $userName)) {
            return false;
        }

        return true;
    }

    /**
     * Validates a user's email
     * @param string $email. User's email
     * @return bool true if email is validated, else false
     */
    public static function validateEmail($email) {
        if (empty($email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

}