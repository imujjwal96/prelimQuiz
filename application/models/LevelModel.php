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

    }

}