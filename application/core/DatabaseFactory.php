<?php

class DatabaseFactory {
    private static $factory;
    private $database;
    private $databaseMongo;

    public static function getFactory() {
        if (!self::$factory) {
            self::$factory = new DatabaseFactory();
        }
        return self::$factory;
    }

    public function getConnection() {
        if (!$this->database) {
            try {
                $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
                $this->database = new PDO(
                    Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ';dbname=' .
                    Config::get('DB_NAME') . ';port=' . Config::get('DB_PORT') . ';charset=' . Config::get('DB_CHARSET'),
                    Config::get('DB_USER'), Config::get('DB_PASS'), $options
                );
                $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {

                // Echo custom message. Echo error code gives you some info.
                echo 'Database connection can not be estabilished. Please try again later.' . '<br>';
                echo 'Error code: ' . $e->getCode();

                // Stop application :(
                // No connection, reached limit connections etc. so no point to keep it running
                exit;
            }
        }
        return $this->database;
    }

    public function getConnectionMongo() {
        if (!$this->databaseMongo) {
            $connection = new MongoDB\Client("mongodb://localhost:27017");
            $this->databaseMongo = $connection->selectDatabase(Config::get('DB_NAME'));
        }
        return $this->databaseMongo;
    }


}
