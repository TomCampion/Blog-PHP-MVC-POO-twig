<?php
require 'MODEL/UserManager.php';
require 'MODEL/Users.php';
require 'Services/Helper.php';

class SecurityController {  

    public function register($firstname, $lastname, $email, $password){
	
		$message = '';
		$user_id = NULL;
		$helper = new Helper();
		$userManager = new UserManager();
		$user = new Users();

		if(strlen($password) < 3) 
			$message = '<p style="color:#db2727;">Votre mot de passe est trop court, il doit faire au moins 3 caractère </p>';
		if(!$helper->isAlpha($firstname)) 
			$message = $message.'<p style="color:#db2727;">Le champ nom ne peut contenir que des lettres ! </p>';
		if(!$helper->isAlpha($lastname)) 
			$message = $message.'<p style="color:#db2727;">Le champ prénom ne peut contenir que des lettres ! </p>';
		if(!$userManager->isEmailUnique($email))
			$message = $message.'<p style="color:#db2727;">Cette adresse e-mail est déjà utilisé </p>';
		if(!$helper->isEmail($email))
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

			$user_id = $userManager->add($user);

			$message = '<p style="color:#27db4e;">Votre compte à bien été crée ! Bienvenue '.$firstname.'</p>';		
		}
		
		$result['message'] = $message;
		$result['user_id'] = $user_id;	

		return $result;
	}

}