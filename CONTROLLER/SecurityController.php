<?php
namespace Tom\Blog\Controller;

require 'Services/Helper.php';

class SecurityController extends Controller{

    private $helper;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new \Helper();
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    private function register($firstname, $lastname, $email, $password){

        $message = '';
        $user = new \Tom\Blog\Model\Users();

        if(strlen($password) < 3)
            $message = '<p style="color:#db2727;">Votre mot de passe est trop court, il doit faire au moins 3 caractère </p>';
        if(!$this->helper->isAlpha($firstname))
            $message = $message.'<p style="color:#db2727;">Le champ prénom ne peut contenir que des lettres ! </p>';
        if(!$this->helper->isAlpha($lastname))
            $message = $message.'<p style="color:#db2727;">Le champ nom ne peut contenir que des lettres ! </p>';
        if(!$this->userManager->isEmailUnique($email))
            $message = $message.'<p style="color:#db2727;">Cette adresse e-mail est déjà utilisé </p>';
        if(!$this->helper->isEmail($email))
            $message = $message.'<p style="color:#db2727;">L\adresse e-mail n\'est pas valide ! </p>';
        if(strlen($firstname) > 45)
            $message = $message.'<p style="color:#db2727;">La taille maximum du prénom est de 45 caractère ! </p>';
        if(strlen($lastname) > 45)
            $message = $message.'<p style="color:#db2727;">La taille maximum du nom est de 45 caractère ! </p>';
        if(strlen($email) > 254)
            $message = $message.'<p style="color:#db2727;">La taille maximum de l\'email est de 254 caractère ! </p>';
        if(strlen($password) > 254)
            $message = $message.'<p style="color:#db2727;">La taille maximum du mot de passe est de 254 caractère ! </p>';

        if (empty($message)){
            $data = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_ARGON2I),
                'admin' => false,
                'restricted' => false
            ];
            $user->hydrate($data);
            $this->userManager->add($user);
            $message = '<p style="color:#27db4e;">Votre compte à bien été crée ! Vous pouvez désormais vous connecté </p>';
        }

        return $message;
    }

    private function login(String $email, String $password)
    {
        $message = '';

        if(strlen($email) > 254)
            $message = '<p style="color:#db2727;">La taille maximum de l\'email est de 254 caractère ! </p>';
        if(strlen($password) > 254)
            $message = $message.'<p style="color:#db2727;">La taille maximum du mot de passe est de 254 caractère ! </p>';

        if (empty($message)){
            $user = $this->userManager->userExist($email, $password);
            if( !empty($user) ){
                foreach ($user as $key => $value) {
                    if($key != 'password'){
                        $_SESSION[$key]=$value;
                    }
                }
                header('Location: profil');
            }else{
                $message = $message.'<p style="color:#db2727;">Vos identifiants ne sont pas reconnus, vérifiez l’adresse mail et le mot de passe saisis</p>';
            }
        }
        return $message;
    }

    public function executeLogout()
    {
        session_unset();
        session_destroy();
        header('Location: accueil');
    }

    public function executeConnexion(){
        echo  $this->twig->render('connexion.twig');
    }

    public function executeProfil(){
        echo  $this->twig->render('profil.twig');
    }

    public function executeRegister(){
        if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['register_email']) and !empty($_POST['register_password']) ) {

            $msg_register = $this->register($_POST['prenom'], $_POST['nom'], $_POST['register_email'], $_POST['register_password']);
            echo $this->twig->render('connexion.twig', ['message_register' => $msg_register]);
        }else{
            $this->executeConnexion();
        }
    }

    public function executeAuthentification()
    {
        if (!empty($_POST['email']) and !empty($_POST['password'])) {

            $msg_login = $this->login($_POST['email'], $_POST['password']);
            echo $this->twig->render('connexion.twig', ['message_connexion' => $msg_login]);
        }else{
            $this->executeConnexion();
        }
    }

}