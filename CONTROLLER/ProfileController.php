<?php
namespace Tom\Blog\Controller;

class ProfileController extends Controller{

    private $helper;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new \Tom\Blog\Services\Helper();
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    public function executeProfil(){
        echo  $this->twig->render('profil.twig');
    }

    private function editProfile(String $firstname, String $lastname, String $email){
        $message = '';
        if(!$this->helper->isAlpha($firstname))
            $message = $message.'<p class="msg_error">Le champ prénom ne peut contenir que des lettres ! </p>';
        if(strlen($firstname) > 45)
            $message = $message.'<p class="msg_error">La taille maximum du prénom est de 45 caractères ! </p>';
        if(!$this->helper->isAlpha($lastname))
            $message = $message.'<p class="msg_error">Le champ nom ne peut contenir que des lettres ! </p>';
        if(strlen($lastname) > 45)
            $message = $message.'<p class="msg_error">La taille maximum du nom est de 45 caractères ! </p>';
        if(!$this->helper->isEmail($email))
            $message = $message.'<p class="msg_error">L\adresse e-mail n\'est pas valide ! </p>';
        if(strlen($email) > 254)
            $message = $message.'<p class="msg_error">La taille maximum de l\'email est de 254 caractères ! </p>';

        if (empty($message)) {
            $this->userManager->update($firstname, $lastname, $email, $_SESSION['id']);
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            header('Location: profil');
        }else{
            $message = '<div class="alert alert-danger" role="alert"><strong>'.$message.'</strong></div>';
        }
        return $message;
    }

    public function executeEditProfile()
    {
        if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email'])) {
            $msg_edit = $this->editProfile($_POST['prenom'], $_POST['nom'], $_POST['email']);
            echo $this->twig->render('profil.twig', ['msg' => $msg_edit]);
        }
    }

}