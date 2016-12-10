<?php

use Application\Core\Session;

$flash_success = Session::get('flash_success');
$flash_message = Session::get('flash_message');
$flash_error   = Session::get('flash_error');

if ($flash_success != null) {
    foreach ($flash_success as $flash) {
        echo '<div class="alert alert-success alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ' . $flash .'
              </div>';
    }
}

if ($flash_message != null) {
    foreach ($flash_message as $flash) {
        echo '<div class="alert alert-info alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ' . $flash .'
              </div>';
    }
}

if ($flash_error != null) {
    foreach ($flash_error as $flash) {
        echo '<div class="alert alert-danger alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ' . $flash .'
              </div>';
    }
}