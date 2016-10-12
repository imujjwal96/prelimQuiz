<?php

class LevelModel {
    public static function getUserLevel() {
            $user = UserModel::getUserByUsername(Session::get('user_name'));
            return $user->level;
    }

    public static function updateLevel() {

    }

    public static function getCurrentQuestion() {
        $str = file_get_contents('../database/questions_sample.json');
        $level = self::getUserLevel();
        $json = json_decode($str);

        foreach ($json as $item) {
            if ($item->id == ($level + 1)) {
                return $item;
            }
        }
        return false;
    }

    public static function getTotalQuestions() {
        $str = file_get_contents('../database/questions_sample.json');
        $json = json_decode($str);
        $i = 0;
        foreach ($json as $item) {
            $i++;
        }
        return $i;
    }

    public static function getQuestionType() {
        return self::getCurrentQuestion()->type;
    }

    public static function getQuestionStatement() {
        return self::getCurrentQuestion()->statement;
    }

    public static function getQuestionPoints() {
        return self::getCurrentQuestion()->points;
    }

    public static function getAnswer() {
        return self::getCurrentQuestion()->answer;
    }

    public static function storeUserAnswer($input, $level) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $level = $level + 1;
        $query = $database->prepare("UPDATE answers SET `$level` = :input WHERE username = :username LIMIT 1");
        $query->execute(array(
            ':input' => $input,
            ':username' => Session::get('user_name')
        ));

        $query = $database->prepare("UPDATE info SET datetime = NOW() WHERE username = :username LIMIT 1");
        $query->execute(array(
            ':username' => Session::get('user_name')
        ));

        $count = $query->rowCount();
        if ($count == 1) {
            return true;
        }
        return false;
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
}