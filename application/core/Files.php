<?php

namespace Application\Core;

class Files {

    public static function uploadFile()
    {

    }

    public static function isImage($file)
    {
        //$fileType = pathinfo(basename($file["name"]),PATHINFO_EXTENSION);
       // if ($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg" || $fileType == "gif") {
            return true;
      //  }
     //   return false;
    }

}