<?php

class LevelModel {
    public static function getUserLevel() {
            $user = UserModel::getUserByUsername(Session::get('user_name'));
            return $user->level;
    }

    public static function updateLevel() {

    }

    public static function getCurrentQuestion() {
        $questions = self::getQuestions();
        $level = self::getUserLevel();
        $i = 0;
        foreach ($questions as $question) {
            if ($i == $level) {
                return $question;
            }
            $i++;
        }
        return false;
    }

    public static function getTotalQuestions() {
        $database = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $database->selectCollection("questions");

        return $questions->count();
    }

    public static function getQuestionType() {
        return self::getCurrentQuestion()->type;
    }

    public static function getQuestionStatement() {
        return self::getCurrentQuestion()->statement;
    }

    public static function getQuestionPoints() {
        return self::getCurrentQuestion()->points ? self::getCurrentQuestion()->points  : 2;
    }

    public static function getAnswer() {
        return self::getCurrentQuestion()->answer;
    }

    public static function storeMCQQuestion($questionStatement, $optionA, $optionB, $optionC, $optionD, $answer) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $databaseMongo->selectCollection("questions");
        $document = array(
            "type" => "MCQ",
            "statement" => $questionStatement,
            "options" => [
                "a" => $optionA,
                "b" => $optionB,
                "c" => $optionC,
                "d" => $optionD
            ],
            "answer" => $answer
        );
        if ($questions->insertOne($document)) {
            return true;
        }
        return false;
    }

    public static function storeGeneralQuestion($questionStatement, $answer) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $databaseMongo->selectCollection("questions");
        $document = array(
            "type" => "General",
            "statement" => $questionStatement,
            "answer" => $answer
        );
        if ($questions->insertOne($document)) {
            return true;
        }
        return false;
    }

    public static function getQuestions() {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();
        $questions = $databaseMongo->selectCollection("questions");
        return $questions->find()->toArray();
    }

    public static function deleteQuestionById($id) {
        $databaseMongo = DatabaseFactory::getFactory()->getConnectionMongo();

        $deleteResult = $databaseMongo->selectCollection("questions")->deleteOne(['_id' => $id]);
    }
}