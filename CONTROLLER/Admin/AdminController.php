<?php
require 'vendor/autoload.php';

class FrontendController {

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


    public function Render($page){

        if(file_exists ( 'VIEW/frontend/'.$page.'.twig' )){
           echo $this->twig->render($page.'.twig'); 
        }else{
           echo $this->twig->render('404.twig'); 
        }
        
    }

    public function RenderPost($idPost){
        //récupérer info article dans la bdd
        echo  $this->twig->render('post.twig', ['id_post' => $idPost ]);  
    }

}