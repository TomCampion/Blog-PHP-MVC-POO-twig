<?php
namespace Tom\Blog\Controller;

use Tom\Blog\Services\Session;

class SecurityController extends Controller{

    private $helper;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new \Tom\Blog\Services\Helper();
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    private function CheckFirstname ($firstname){
        $message = '';
        if(!$this->helper->isAlpha($firstname))
            $message = $message.'<p class="msg_error">Le champ prénom ne peut contenir que des lettres ! </p>';
        if(strlen($firstname) > 45)
            $message = $message.'<p class="msg_error">La taille maximum du prénom est de 45 caractères ! </p>';

        return $message;
    }

    private function checkLastname($lastname){
        $message = '';
        if(!$this->helper->isAlpha($lastname))
            $message = $message.'<p class="msg_error">Le champ nom ne peut contenir que des lettres ! </p>';
        if(strlen($lastname) > 45)
            $message = $message.'<p class="msg_error">La taille maximum du nom est de 45 caractères ! </p>';

        return $message;
    }

    private function checkEmail($email){
        $message = '';
        if(!$this->helper->isEmail($email))
            $message = $message.'<p class="msg_error">L\adresse e-mail n\'est pas valide ! </p>';
        if(strlen($email) > 254)
            $message = $message.'<p class="msg_error">La taille maximum de l\'email est de 254 caractères ! </p>';

        return $message;
    }

    private function checkPassword($password){
        $message = '';
        if(strlen($password) < 3)
            $message = '<p class="msg_error">Votre mot de passe est trop court, il doit faire au moins 3 caractères </p>';
        if(strlen($password) > 254)
            $message = $message.'<p class="msg_error">La taille maximum du mot de passe est de 254 caractères ! </p>';

        return $message;
    }

    private function register(String $firstname, String $lastname, String $email, String $password){
        if (Session::get('register_token') == filter_input(INPUT_POST, 'token')) {
            $message = $this->checkFirstname($firstname);
            $message .= $this->checkLastname($lastname);
            $message .= $this->checkEmail($email);
            $message .= $this->checkPassword($password);
            if (!$this->userManager->isEmailUnique($email))
                $message .= '<p class="msg_error">Cette adresse e-mail est déjà utilisé </p>';
            if (empty($message)) {
                $data = [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_ARGON2I),
                    'admin' => false,
                    'restricted' => false
                ];
                $user = new \Tom\Blog\Model\Users();
                $user->hydrate($data);
                $this->userManager->add($user);
                $message = '<p class="msg_success">Votre compte à bien été crée ! Vous pouvez désormais vous connecté </p>';
            }
            return $message;
        }
    }

    private function login(String $email, String $password)
    {
        if (Session::get('login_token') == filter_input(INPUT_POST, 'token')) {
            $message = $this->checkEmail($email);
            $message .= $this->checkPassword($password);
            if (empty($message)) {
                $user = $this->userManager->authenticate($email, $password);
                if (!empty($user)) {
                    foreach ($user as $key => $value) {
                        if ($key == 'id' or $key == 'firstname' or $key == 'lastname' or $key == 'email' or $key == 'admin' or $key == 'restricted' or $key == 'register_date') {
                            Session::put($key,$value);
                        }
                    }
                    header('Location: profil');
                } else {
                    $message = '<p class="msg_error">Vos identifiants ne sont pas reconnus, vérifiez l’adresse mail et le mot de passe saisis</p>';
                }
            }
            return $message;
        }
    }

    public function executeAuthentification()
    {
        if (!empty(filter_input(INPUT_POST, 'email')) and !empty(filter_input(INPUT_POST, 'password'))) {
            $msg_login = $this->login(filter_input(INPUT_POST, 'email'), filter_input(INPUT_POST, 'password'));
            $this->twig->display('connexion.twig', ['message_connexion' => $msg_login]);
        }else{
            $this->executeLoginPage();
        }
    }

    public function executeRegister(){
        if(!empty(filter_input(INPUT_POST, 'nom')) and !empty(filter_input(INPUT_POST, 'prenom')) and !empty(filter_input(INPUT_POST, 'register_email')) and !empty(filter_input(INPUT_POST, 'register_password'))) {
            $msg_register = $this->register(filter_input(INPUT_POST, 'prenom'), filter_input(INPUT_POST, 'nom'), filter_input(INPUT_POST, 'register_email'), filter_input(INPUT_POST, 'register_password'));
            $this->twig->display('connexion.twig', ['message_register' => $msg_register]);
        }else{
            $this->executeLoginPage();
        }
    }

    public function executeLoginPage(){
        $this->twig->display('connexion.twig');
    }

    public function executeLogout()
    {
        if (Session::get('logout_token') == filter_input(INPUT_POST, 'token')) {
            session_unset();
            session_destroy();
            header('Location: accueil');
        }else{
            header('Location: connexion');
        }
    }
}
