<?php
namespace Tom\Blog\Controller;

class FrontendController extends Controller{

    public function executeAccueil(){
        echo  $this->twig->render('accueil.twig');
    }

    public function executeA_propos(){
        echo  $this->twig->render('a_propos.twig');
    }

    public function executeContact(){
        echo  $this->twig->render('contact.twig');
    }

    public function executeCv(){
        echo  $this->twig->render('cv.twig');
    }

    public function executePortfolio(){
        echo  $this->twig->render('portfolio.twig');
    }

    public function executeProjet1(){
        echo  $this->twig->render('projet1.twig');
    }

    public function execute404(){
        echo $this->twig->render('404.twig');
    }
}