<?php
require 'MODEL/UserManager.php';
require 'MODEL/Users.php';
require 'Services/Helper.php';

class SecurityController {  

	private $helper;
	private $userManager;

	public function __construct()
	{
		$this->helper = new Helper();
		$this->userManager = new UserManager();
	}

    public function register($firstname, $lastname, $email, $password){
	
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

	public function login(String $email, String $password)
	{
		$user_id = $this->userManager->userExist($email, $password);

		if( is_int($user_id) and $user_id > 0){

			$user = $this->userManager->get($user_id);
			foreach ($user as $key => $value) {		
				if($key != 'password'){
					$_SESSION[$key]=$value;
				}
			}
			$message = '<p style="color:#27db4e;">Vous êtes désormais connecté ! </p>';	
		}else{
			$message = '<p style="color:#db2727;">Vos identifiants ne sont pas reconnus, vérifiez l’adresse mail et le mot de passe saisis</p>';
		}

		return $message;
	}

	public function logout()
	{
		session_unset();
		session_destroy();
	}
}