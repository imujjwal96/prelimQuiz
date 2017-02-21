<?php

namespace PQ\Models;

use PQ\Core\DatabaseFactory;
use PQ\Core\Session;

/**
 * Class UserModel
 * Handles all the User Profile stuff
 */
class User {

    protected $Session;

    public function __construct()
    {
        $this->Session = new Session();
    }

    /**
     * Checks if there is any user in the database
     * @return bool true if users exist else false
     */
    public function doesUsersExist() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM info";
        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() != 0) {
            return true;
        }
        return false;
    }

    /**
     * Checks if a user exists
     * @param $parameter. (includes email, user_id, username)
     * @param $value. value of the parameter
     * @return bool true if user exists else false
     */
    public function doesUserExist($parameter, $value) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM info WHERE $parameter = :value";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':value' => $value
        ));

        if ($query->rowCount() != 0) {
            return true;
        }
        return false;
    }

    /**
     * Get user in an order of decreasing points
     * @return array|bool array of user objects if users exist else false
     */
    public function getUsersByPoints() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM info ORDER BY points DESC";
        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() != 0) {
            return $query->fetchAll();
        }
        return false;

    }

    /**
     * Gets a user by ID
     * @param int $userID. The user's id
     * @return bool|mixed object of user's details if user found else false
     */
    public function getUserByID($userID) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM info WHERE id = :userID";
        $query = $database->prepare($sql);
        $query->execute(array(':userID' => $userID));

        if ($query->rowCount() == 1) {
            return $query->fetch();
        }
        return false;
    }

    /**
     * Gets a user by email
     * @param string $email. User's email address
     * @return bool|mixed object of user's details if user is found else false
     */
    public function getUserByEmail($email) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM info WHERE email = :email";
        $query = $database->prepare($sql);
        $query->execute(array(':email' => $email));

        if ($query->rowCount() == 1) {
            return $query->fetch();
        }
        return false;
    }

    /**
     * Gets a user by username
     * @param string $userName. The user's username
     * @return bool|mixed object of user's details if user is found else false
     */
    public function getUserByUsername($userName) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM info WHERE username = :username";
        $query = $database->prepare($sql);
        $query->execute(array(':username' => $userName));

        if ($query->rowCount() == 1) {
            return $query->fetch();
        }
        return false;
    }

    /**
     * Increments points of a user (after each correct answer)
     * @param int $points Value by which the points are to be incremented
     * @return bool true if successfully incremented else false
     */
    public function incrementPoints($points) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE info SET points = points + :points WHERE username = :user_name LIMIT 1");
        $query->execute(array(
            ':points' => $points,
            ':user_name' => $this->Session->get('user_name')
        ));
        $count = $query->rowCount();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    /**
     * Increments Level of a user.
     * @return bool true if incremented successfully else false.
     */
    public function incrementLevel() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE info SET level = level + 1 WHERE username = :user_name LIMIT 1");
        $query->execute(array(
            ':user_name' => $this->Session->get('user_name')
        ));
        $count = $query->rowCount();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    /**
     * Gets a user's level.
     * @return bool|int The current level of the user else false.
     */
    public function getUserLevel() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT level FROM info WHERE username = :username";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':username' => Session::get('user_name')
        ));

        if ($query->rowCount() == 1) {
            return $query->fetch()->level;
        }
        return false;
    }

    /**
     * Checks if a user is admin
     * @return bool true if admin else false
     */
    public function isAdmin() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("SELECT role FROM info WHERE username = :username");
        $query->execute(array(
            ':username' => $this->Session->get('user_name')
        ));

        if ($query->fetch()->role == "admin") {
            return true;
        }
        return false;
    }
}