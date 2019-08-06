<?php

class FrontendController extends tom\controller\Controller{


    public function renderAccueil(){
        echo  $this->twig->render('accueil.twig');  
    }

    public function renderA_propos(){
        echo  $this->twig->render('a_propos.twig');  
    }

    public function renderContact(){
        echo  $this->twig->render('contact.twig');  
    }

    public function renderCv(){
        echo  $this->twig->render('cv.twig');  
    }

    public function renderPortfolio(){
        echo  $this->twig->render('portfolio.twig');  
    }

    public function renderProjet1(){
        echo  $this->twig->render('projet1.twig');  
    }

}