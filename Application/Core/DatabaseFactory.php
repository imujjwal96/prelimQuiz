<?php

namespace PQ\Core;

class DatabaseFactory {
    private $factory;
    private $database;
    private $databaseMongo;
    private $Config;

    public function __construct()
    {
        $this->Config = new Config();
    }

    public function getFactory() {
        if (!$this->factory) {
            $this->factory = new DatabaseFactory();
        }
        return $this->factory;
    }

    public function getConnection() {
        if (!$this->database) {
            try {
                $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING);
                $this->database = new \PDO(
                    $this->Config->get('DB_TYPE') . ':host=' . $this->Config->get('DB_HOST') . ';dbname=' .
                    $this->Config->get('DB_NAME') . ';port=' . $this->Config->get('DB_PORT') . ';charset=' . $this->Config->get('DB_CHARSET'),
                    $this->Config->get('DB_USER'), $this->Config->get('DB_PASS'), $options
                );
                $this->database->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\PDOException $e) {

                echo 'Database connection can not be established. Please try again later.' . '<br>';
                echo 'Error code: ' . $e->getCode();
                exit;
            }
        }
        return $this->database;
    }

    public function getConnectionMongo() {
        if (!$this->databaseMongo) {
            $connection = new \MongoDB\Client($this->Config->get('MONGO_HOST'));
            $this->databaseMongo = $connection->selectDatabase($this->Config->get('DB_NAME'));
        }
        return $this->databaseMongo;
    }
}
