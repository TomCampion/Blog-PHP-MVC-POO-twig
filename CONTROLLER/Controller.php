<?php
namespace Tom\Blog\Controller;

class Controller{

    protected $twig;

    public function __construct(String $backend = null){

        if($backend == 'backend'){
            $loader = new \Twig_Loader_Filesystem('VIEW/backend');
        }else{
            $loader = new \Twig_Loader_Filesystem('VIEW/frontend');
        }
        $this->twig = new \Twig_Environment($loader, [
            //'cache' => __DIR__ . '/tmp',
            'debug' => true
        ]);

        $function = new \Twig\TwigFunction('csrf_token', function (String $id) {
            $bytes = random_bytes(256 / 8);
            $val = rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
            $_SESSION[$id.'_token'] = $val;
            return $val;
        });
        $this->twig->addFunction($function);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new \Twig_Extension_Debug());
    }

}