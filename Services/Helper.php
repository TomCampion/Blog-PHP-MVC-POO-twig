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
}