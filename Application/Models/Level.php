<?php

namespace PQ\Models;

use PQ\Core\Session;
use PQ\Core\DatabaseFactory;

/**
 * Class LevelModel
 * Handles questions and user levels
 */
class Level {

    protected $user;

    public function __construct() {
        $this->user = new User();
    }

    /**
     * Gets a user's level with information gathered from the session
     * @return int level the user is currently in.
     */
    public function getUserLevel() {
            return $this->user->getUserByUsername(Session::get('user_name'))->level;
    }

    /**
     * Gets the current question for the user to solve
     * @return mixed/bool question object if a question is found, else false
     */
    public function getCurrentQuestion() {
        $questions = $this->getQuestions();
        $level = $this->getUserLevel();
        $i = 0;
        foreach ($questions as $question) {
            if ($i == $level) {
                return $question;
            }
            $i++;
        }
        return false;
    }

    /**
     * Gets the total number of questions
     * @return int total number of questions
     */
    public function getTotalQuestions() {
        $database = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $database->selectCollection("questions");

        return $questions->count();
    }

    /**
     * Gets the type of the question  (General / MCQ)
     * @return string. Question type
     */
    public function getQuestionType() {
        return $this->getCurrentQuestion()->type;
    }

    /**
     * Gets the statement of the question.
     * @return string. Statement of the question
     */
    public function getQuestionStatement() {
        return $this->getCurrentQuestion()->statement;
    }

    /**
     * Get the points of the current question
     * @return int points
     */
    public function getQuestionPoints() {
        return $this->getCurrentQuestion()->points ? $this->getCurrentQuestion()->points : 2;
    }

    /**
     * Gets the answer of the current questions
     * @return string answer
     */
    public function getAnswer() {
        return $this->getCurrentQuestion()->answer;
    }

    /**
     * Stores an MCQ question to the Mongo Database
     * @param string $questionStatement. Statement of the question.
     * @param string $questionCover. Cover image.
     * @param string $optionA. First option.
     * @param string $optionB. Second option.
     * @param string $optionC. Third option.
     * @param string $optionD. Fourth option.
     * @param string $answer. Answer to the question.
     * @return bool true if the question is stored successfully, else false
     */
    public function storeMCQQuestion($questionStatement, $questionCover, $optionA, $optionB, $optionC, $optionD, $answer) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $databaseMongo->selectCollection("questions");
        $document = array(
            "type" => "MCQ",
            "statement" => $questionStatement,
            "cover" => new \MongoDB\BSON\Binary(file_get_contents($questionCover["tmp_name"]), \MongoDB\BSON\Binary::TYPE_GENERIC),
            "options" => [
                "a" => $optionA,
                "b" => $optionB,
                "c" => $optionC,
                "d" => $optionD
            ],
            "answer" => $answer
        );
        if ($questions->insertOne($document)) {
            Session::add("flash_success", "Question added successfully.");
            return true;
        }
        Session::add("flash_error", "Failed to add question.");
        return false;
    }

    /**
     * Stores an General question to the Mongo Database
     * @param string $questionStatement. Statement of the question.
     * @param $questionCover
     * @param string $answer. Answer to the question.
     * @return bool true if the question is stored successfully, else false.
     */
    public function storeGeneralQuestion($questionStatement, $questionCover, $answer) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $databaseMongo->selectCollection("questions");
        $document = array(
            "type" => "General",
            "statement" => $questionStatement,
            "cover" => new \MongoDB\BSON\Binary(file_get_contents($questionCover["tmp_name"]), \MongoDB\BSON\Binary::TYPE_GENERIC),
            "answer" => $answer
        );
        if ($questions->insertOne($document)) {
            Session::add("flash_success", "Question added successfully.");
            return true;
        }
        Session::add("flash_error", "Failed to add question.");
        return false;
    }

    /**
     * Gets all the questions from the database in the form of an array
     * @return array
     */
    public function getQuestions() {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $databaseMongo->selectCollection("questions");
        return $questions->find()->toArray();
    }

    /**
     * Deletes a question by its id
     * @param string $id. id of the question (stored in the database)
     * @return true if question deleted successfully else false
     */
    public function deleteQuestionById($id) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $deleteResult = $databaseMongo->selectCollection("questions")->findOneAndDelete(['_id' => new \MongoDB\BSON\ObjectID($id)]);

        if ($deleteResult != null) {
            return true;
        }
        return false;
    }

    /**
     * Gets a question by its id
     * @param string $id. id of the question (stored in the database)
     * @return array question if found else empty array
     */
    public function getQuestionById($id) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $question = $databaseMongo->selectCollection("questions")->findOne(['_id' => new \MongoDB\BSON\ObjectID($id)]);

        if ($question != null) {
            return $question;
        }
        return [];
    }
}