<?php
namespace Tom\Blog\Controller;

class FrontendController extends Controller{

    public function executeAccueil(){
        $this->twig->display('accueil.twig');
    }

    public function executeA_propos(){
        $this->twig->display('a_propos.twig');
    }

    public function executeContact(){
        $this->twig->display('contact.twig');
    }

    public function executeCv(){
        $this->twig->display('cv.twig');
    }

    public function executePortfolio(){
        $this->twig->display('portfolio.twig');
    }

    public function executeProjet1(){
        $this->twig->display('projet1.twig');
    }

    public function executeProjet2(){
        $this->twig->display('projet2.twig');
    }

    public function executeProjet3(){
        $this->twig->display('projet3.twig');
    }

    public function executeProjet4(){
        $this->twig->display('projet4.twig');
    }

    public function executeProjet5(){
        $this->twig->display('projet5.twig');
    }

    public function execute404(){
        $this->twig->display('404.twig');
    }
}