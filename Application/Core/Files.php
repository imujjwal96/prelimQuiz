<?php

namespace PQ\Core;

class Files {

    public function uploadFile()
    {

    }

    public function isImage($file)
    {
        //$fileType = pathinfo(basename($file["name"]),PATHINFO_EXTENSION);
       // if ($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg" || $fileType == "gif") {
            return true;
      //  }
     //   return false;
    }

}