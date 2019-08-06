<?php
require 'Services/Helper.php';

class SecurityController extends tom\controller\Controller{

	private $helper;
	private $userManager;
	
	public function __construct()
	{
		parent::__construct();
		$this->helper = new Helper();
		$this->userManager = new UserManager();
	}
	
    private function register($firstname, $lastname, $email, $password){
	
		$message = '';
		$user = new Users();
		if(strlen($password) < 3) 
			$message = '<p style="color:#db2727;">Votre mot de passe est trop court, il doit faire au moins 3 caractère </p>';
		if(!$this->helper->isAlpha($firstname)) 
			$message = $message.'<p style="color:#db2727;">Le champ nom ne peut contenir que des lettres ! </p>';
		if(!$this->helper->isAlpha($lastname)) 
			$message = $message.'<p style="color:#db2727;">Le champ prénom ne peut contenir que des lettres ! </p>';
		if(!$this->userManager->isEmailUnique($email))
			$message = $message.'<p style="color:#db2727;">Cette adresse e-mail est déjà utilisé </p>';
		if(!$this->helper->isEmail($email))
			$message = $message.'<p style="color:#db2727;">L\adresse e-mail n\'est pas valide ! </p>';
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
	
	public function renderConnexion(){		
        if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['register_email']) and !empty($_POST['register_password']) ){        
            $msg_register = $this->register($_POST['prenom'],$_POST['nom'],$_POST['register_email'],$_POST['register_password']);
            echo  $this->twig->render('connexion.twig', ['message_register' => $msg_register]);  
        }else{
            echo  $this->twig->render('connexion.twig');  
        } 
    }
  
}