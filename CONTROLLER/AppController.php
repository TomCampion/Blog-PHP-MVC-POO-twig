<?php
require 'vendor/autoload.php';
require 'SecurityController.php';
class AppController {

    private $twig;
    private $SecurityController;

    public function __construct(){
        // Rendu du template
        $loader = new Twig_Loader_Filesystem('VIEW/frontend');
        $this->twig = new Twig_Environment($loader, [
            //'cache' => __DIR__ . '/tmp',
            'debug' => true
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new Twig_Extension_Debug());
        $this->SecurityController = new SecurityController();
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
        if(!empty($_SESSION['id'])){
            $current_user_id = $_SESSION['id'];
        }else{
             $current_user_id = null;
        }   

        if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['register_email']) and !empty($_POST['register_password']) ){            
            $msg_register = $this->SecurityController->register($_POST['prenom'],$_POST['nom'],$_POST['register_email'],$_POST['register_password']);
            echo  $this->twig->render('connexion.twig', ['message_register' => $msg_register, 'current_user_id' => $current_user_id]);  
        }elseif(!empty($_POST['email']) and !empty($_POST['password'])){
            $msg_login = $this->SecurityController->login($_POST['email'], $_POST['password']);          
            echo  $this->twig->render('connexion.twig', ['message_connexion' => $msg_login, 'current_user_id' => $current_user_id] ); 
            //render profile page
        }elseif(!empty($_POST['deconnexion'])){
            $this->SecurityController->logout();
            echo  $this->twig->render('accueil.twig');  
        }else{
            echo  $this->twig->render('connexion.twig', ['current_user_id' => $current_user_id]);  
        } 
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