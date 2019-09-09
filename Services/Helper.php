<?php
namespace Tom\Blog\Services;

class Helper{

    public function isAlpha($str)
    {
        $valid = true;
        $regex = preg_match('#^[\p{Latin}\' -]+$#u', $str);
        if(!$regex){
            $valid = false;
        }
        return $valid;
    }

    public function isEmail($field)
    {
        $valid = true;
        if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
        }
        return $valid;
    }

    public function isAdmin($admin){
        if($admin == 1){
            return true;
        }else{
            return false;
        }
    }

    public function mail(String $visitor_email, String $visitor_message, String $visitor_name )
    {
        $recipient = 'tomcampion10@laposte.net';
        $headers = 'MIME-Version: 1.0' . "\r\n"
            . 'Content-type: text/html; charset=utf-8' . "\r\n"
            . 'From: ' . $visitor_email . "\r\n";
        if (mail($recipient, 'CONTACT from tomcampion.fr', $visitor_message, $headers)) {
            return true;
        } else {
            return false;
        }
        return true;
    }
}