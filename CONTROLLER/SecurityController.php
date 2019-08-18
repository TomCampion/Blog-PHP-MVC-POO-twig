<?php
namespace Tom\Blog\Controller;

class SecurityController extends Controller{

    private $helper;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new \Tom\Blog\Services\Helper();
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    public function executeConnexion(){
        echo  $this->twig->render('connexion.twig');
    }

    public function executeProfil(){
        echo  $this->twig->render('profil.twig');
    }

    private function register(String $firstname, String $lastname, String $email, String $password){
        $message = $this->helper->checkFirstname($firstname);
        $message .= $this->helper->checkLastname($lastname);
        $message .= $this->helper->checkEmail($email);
        $message .= $this->helper->checkPassword($password);
        if(!$this->userManager->isEmailUnique($email))
            $message .= '<p class="msg_error">Cette adresse e-mail est déjà utilisé </p>';

        if (empty($message)){
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

    public function executeRegister(){
        if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['register_email']) and !empty($_POST['register_password']) ) {

            $msg_register = $this->register($_POST['prenom'], $_POST['nom'], $_POST['register_email'], $_POST['register_password']);
            echo $this->twig->render('connexion.twig', ['message_register' => $msg_register]);
        }else{
            $this->executeConnexion();
        }
    }

    private function login(String $email, String $password)
    {
        $message = $this->helper->checkEmail($email);
        $message .= $this->helper->checkPassword($password);

        if (empty($message)){
            $user = $this->userManager->userExist($email, $password);
            if( !empty($user) ){
                foreach ($user as $key => $value) {
                    if($key == 'id' or $key == 'firstname' or $key == 'lastname' or $key == 'email' or $key == 'admin' or $key == 'restricted' or $key =='register_date'){
                        $_SESSION[$key]=$value;
                    }
                }
                header('Location: profil');
            }else{
                $message = '<p class="msg_error">Vos identifiants ne sont pas reconnus, vérifiez l’adresse mail et le mot de passe saisis</p>';
            }
        }
        return $message;
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

    public function executeLogout()
    {
        session_unset();
        session_destroy();
        header('Location: accueil');
    }
}