<?php
namespace Tom\Blog\AdminController;

class AdminUsersController extends \Tom\Blog\Controller\Controller{

    private $userManager;

    public function __construct()
    {
        parent::__construct('backend');
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    public function executeUsers(){
        if(!empty($_SESSION['admin']) and $_SESSION['admin'] == 1) {
            if (!empty($_POST['sort']) and !empty($_POST['order'])) {
                $users = $this->userManager->getList($_POST['sort'], $_POST['order']);
            } else {
                $users = $this->userManager->getList();
            }
            echo $this->twig->render('users.twig', ['users' => $users]);
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    public function executeUserAction(){
        if(!empty($_SESSION['admin']) and $_SESSION['admin'] == 1) {
            if (!empty($_POST['action']) and !empty($_POST['users'])) {
                foreach($_POST['users'] as $valeur)
                {
                    if($_POST['action'] == 'setAdmin'){
                        $this->userManager->setAdmin($valeur);
                    }
                    if($_POST['action'] == 'revokeAdmin'){
                        $this->userManager->revokeAdmin($valeur);
                    }
                    if($_POST['action'] == 'restrict'){
                        $this->userManager->restrictUser($valeur);
                    }
                    if($_POST['action'] == 'revokeRestrict'){
                        $this->userManager->revokeRestrict($valeur);
                    }
                }
                $this->executeUsers();
            }else{
                $this->executeUsers();
            }
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

}