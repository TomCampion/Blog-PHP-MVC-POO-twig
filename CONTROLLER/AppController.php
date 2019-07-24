<?php
require 'vendor/autoload.php';

class AppController {

    private $twig;

    public function __construct(){
        // Rendu du template
        $loader = new Twig_Loader_Filesystem('VIEW/frontend');
        $this->twig = new Twig_Environment($loader, [
            //'cache' => __DIR__ . '/tmp',
            'debug' => true
        ]);

        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    public function render($match){
    
        $method = 'render'.ucfirst($match['target']);

        if (method_exists($this, $method)){
            if(!empty($match['params'])){
                $this->$method($match['params']);
            }else{
                $this->$method();
            }
        }else{
            echo  $this->twig->render('404.twig');
        }       
    }

    private function renderConnexion(){
        echo  $this->twig->render('connexion.twig', ['current_user_id' => session_id()]);  
    }

    private function renderPost($params){
        //récupérer info article dans la bdd
        echo  $this->twig->render('post.twig', ['id_post' => $params['id'] ] );  
    }

    private function renderAccueil(){
        echo  $this->twig->render('accueil.twig');  
    }

    private function renderBlog(){
        echo  $this->twig->render('blog.twig');  
    }

    private function renderA_propos(){
        echo  $this->twig->render('a_propos.twig');  
    }

    private function renderContact(){
        echo  $this->twig->render('contact.twig');  
    }

    private function renderCv(){
        echo  $this->twig->render('cv.twig');  
    }

    private function renderPortfolio(){
        echo  $this->twig->render('portfolio.twig');  
    }

    private function renderProjet1(){
        echo  $this->twig->render('projet1.twig');  
    }

}