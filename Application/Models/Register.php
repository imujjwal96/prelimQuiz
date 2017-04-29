<?php

namespace PQ\Models;

use PQ\Core\DatabaseFactory;
use PQ\Core\Session;

/**
 * Class RegisterModel
 * Handles user registration
 */
class Register {

    protected $Session;
    protected $Database;

    private $DatabaseSQL;

    public function __construct()
    {
        $this->Session = new Session();
        $this->Database = (new DatabaseFactory())->getFactory();

        $this->DatabaseSQL = $this->Database->getConnection();
    }

    /**
     * Registers a user
     * @param string $name. User's name
     * @param string $email. User's email
     * @param string $userName. User's username
     * @param string $phone. User's phone number
     * @param string $password. User's password
     * @param string $role. User's role (admin / contestant)
     * @return bool true if user registered successfully, else false
     */
    public function registerNewUser($name, $email, $userName, $phone, $password, $role = 'contestant') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->DatabaseSQL->prepare("INSERT INTO info (name, email, username, phone, password, points, level, role, datetime) VALUES (:name, :email, :username, :phone, :password,  '0', '0', :role, NOW())");
        $query->execute(array(
            ':name' => $name,
            ':email' => $email,
            ':username' => $userName,
            ':phone' => $phone,
            ':password' => $passwordHash,
            ':role' => $role
            ));

        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        }
        $this->Session->add('flash_error', "Failed to register user.");
        return false;
    }

    /**
     * Validates form inputs
     * @param string $userName. User's username
     * @param string $email. User's email
     * @return bool true if credentials are validated, else false
     */
    public function formValidation($userName, $email) {
        if ($this->validateUserName($userName) AND $this->validateEmail($email)) {
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
    public function validateUserName($userName) {
        if (empty($userName)) {
            $this->Session->add('flash_error', "Empty Username");
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9]{2,64}$/', $userName)) {
            $this->Session->add('flash_error', "Invalid username");
            return false;
        }

        return true;
    }

    /**
     * Validates a user's email
     * @param string $email. User's email
     * @return bool true if email is validated, else false
     */
    public function validateEmail($email) {
        if (empty($email)) {
            $this->Session->add('flash_error', "Empty Email");
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->Session->add('flash_error', "Invalid Email");
            return false;
        }
        return true;
    }

}