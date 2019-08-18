<?php
namespace Tom\Blog\Services;

class Helper{

    private function isAlpha($str)
    {
        $valid = true;
        $regex = preg_match('#^[\p{Latin}\' -]+$#u', $str);
        if(!$regex){
            $valid = false;
        }
        return $valid;
    }

    private function isEmail($field)
    {
        $valid = true;
        if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
        }
        return $valid;
    }

    private function CheckFirstname ($firstname){
        $message = '';
        if(!$this->isAlpha($firstname))
            $message = $message.'<p class="msg_error">Le champ prénom ne peut contenir que des lettres ! </p>';
        if(strlen($firstname) > 45)
            $message = $message.'<p class="msg_error">La taille maximum du prénom est de 45 caractères ! </p>';

        return $message;
    }

    private function checkLastname($lastname){
        $message = '';
        if(!$this->isAlpha($lastname))
            $message = $message.'<p class="msg_error">Le champ nom ne peut contenir que des lettres ! </p>';
        if(strlen($lastname) > 45)
            $message = $message.'<p class="msg_error">La taille maximum du nom est de 45 caractères ! </p>';

        return $message;
    }

    private function checkEmail($email){
        $message = '';
        if(!$this->isEmail($email))
            $message = $message.'<p class="msg_error">L\adresse e-mail n\'est pas valide ! </p>';
        if(strlen($email) > 254)
            $message = $message.'<p class="msg_error">La taille maximum de l\'email est de 254 caractères ! </p>';

        return $message;
    }

    private function checkPassword($password){
        $message = '';
        if(strlen($password) < 3)
            $message = '<p class="msg_error">Votre mot de passe est trop court, il doit faire au moins 3 caractères </p>';
        if(strlen($password) > 254)
            $message = $message.'<p class="msg_error">La taille maximum du mot de passe est de 254 caractères ! </p>';

        return $message;
    }

}