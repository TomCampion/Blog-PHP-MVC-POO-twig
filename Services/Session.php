<?php
namespace Tom\Blog\Services;

class Session{

    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        if(!empty($_SESSION[$key])){
             return filter_var($_SESSION[$key], FILTER_SANITIZE_STRING);
        }else{
            return null;
        }
    }

    public static function forget($key){
        unset($_SESSION[$key]);
    }
}