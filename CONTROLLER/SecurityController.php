<?php
namespace Tom\Blog\Controller;

class SecurityController extends Controller{

    public function executeConnexion(){
        echo  $this->twig->render('connexion.twig');
    }

    public function executeProfil(){
        echo  $this->twig->render('profil.twig');
    }

}