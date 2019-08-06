<?php
namespace tom\controller;

require 'MODEL/Manager.php';
require 'MODEL/UserManager.php';
require 'MODEL/Users.php';
require 'MODEL/PostManager.php';

class Controller{

    protected $twig;

    public function __construct(){
        
        $loader = new \Twig_Loader_Filesystem('VIEW/frontend');
        $this->twig = new \Twig_Environment($loader, [
            //'cache' => __DIR__ . '/tmp',
            'debug' => true
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new \Twig_Extension_Debug());
    }

    public function render($match = false){
        if(!empty($match)){
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
        }else{
            echo  $this->twig->render('404.twig');
        }     
    }
  
}