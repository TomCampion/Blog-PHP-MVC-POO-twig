<?php
namespace Tom\Blog\Controller;

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

    public function execute($match = false){
        if(!empty($match)){
            $method = 'execute'.ucfirst($match['target']);

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