<?php

namespace PQ\Models;

use PQ\Core\DatabaseFactory;

class Token
{

    protected $Database;

    private $DatabaseSQL;

    public function __construct()
    {
        $this->Database = (new DatabaseFactory())->getFactory();
        $this->DatabaseSQL = $this->Database->getConnection();
    }

    public function set($userId, $key, $value) {
        if ($this->get($userId, $key) !== false) {
            if ($this->isExpired($userId, $key)) {
                $this->delete($userId, $key);
            } else {
                return true;
            }
        }

        $timestamp = time();

        $query = $this->DatabaseSQL->prepare("INSERT INTO user_token(id, userid, tokenkey, tokenvalue, timestamp) VALUES (NULL, :userid, :key, :value, :timestamp )");
        $query->execute([
            ':userid' => $userId,
            ':key' => $key,
            ':value' => $value,
            ':timestamp' => $timestamp
        ]);

        if ($query->rowCount() === 1) {
            return true;
        }
        return false;
    }

    public function get($userId, $key) {
        $query = $this->DatabaseSQL->prepare("SELECT tokenvalue FROM user_token WHERE userid = :userid AND tokenkey = :key");
        $query->execute([
            ':userid' => $userId,
            ':key' => $key
        ]);

        if ($query->rowCount() === 1) {
            return $query->fetch()->tokenvalue;
        }
        return false;
    }

    public function delete($userId, $key) {
        $query = $this->DatabaseSQL->prepare("DELETE FROM user_token WHERE userid = :userid AND tokenkey = :key");
        $query->execute([
            ':userid' => $userId,
            ':key' => $key,
        ]);

        return true;
    }

    public function getTimestamp($userId, $key) {
        $query = $this->DatabaseSQL->prepare("SELECT timestamp FROM user_token WHERE userid = :userid AND tokenkey = :key");
        $query->execute([
            ':userid' => $userId,
            ':key' => $key,
        ]);

        if ($query->rowCount() === 1) {
            return $query->fetch()->timestamp;
        }
        return false;
    }

    public function isExpired($userId, $key) {
        if ($this->getTimestamp($userId, $key) >= (time() - 60*60*24)) {
            return false;
        }
        return true;
    }
}