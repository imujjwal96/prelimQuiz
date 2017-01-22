<?php

namespace PQ\Core;

class Redirect
{
    public static function to($path)
    {
        header("location: " . Config::get('URL') . $path);
    }
}
