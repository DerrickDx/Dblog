<?php

function redirect($page){
    header('location: '.URLROOT.'/'.$page);
}

function messageDisplay($message = '', $name = 'msg') {
    if(empty($_SESSION[$name])){
        $_SESSION[$name] = $message;
    } else {
        unset($_SESSION[$name]);
    }
}

