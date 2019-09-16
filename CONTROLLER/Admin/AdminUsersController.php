<?php
namespace Tom\Blog\AdminController;

class AdminUsersController extends \Tom\Blog\Controller\Controller{

    private $userManager;
    private $Helper;

    public function __construct()
    {
        parent::__construct('backend');
        $this->userManager = new \Tom\Blog\Model\UserManager();
        $this->Helper = new \Tom\Blog\Services\Helper();
    }

    public function executeUsers($params = null){
        $nbrpost = 14;
        $nbr_pages = ceil($this->userManager->getUsersNumber()/$nbrpost);

        if(empty($params['page'])){
            $params['page'] = 1;
        }
        if($params['page']  > $nbr_pages){
            $params['page']  = ceil($this->userManager->getUsersNumber()/$nbrpost);
        }
        if($this->Helper->isAdmin()) {
            if (!empty($_POST['sort']) and !empty($_POST['order']) and $_SESSION['sortUsers_token'] == $_POST['token']) {
                $users = $this->userManager->getList("users",$_POST['sort'], $_POST['order'],(int)$params['page'] , $nbrpost);
            } else {
                $users = $this->userManager->getList("users",null, null, (int)$params['page'] , $nbrpost);
            }
            echo $this->twig->render('users.twig', ['users' => $users, 'page'=> (int)$params['page'], 'nbr_pages'=> $nbr_pages ]);
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    public function executeUserAction(){
        if ($_SESSION['usersAction_token'] == $_POST['token']) {
            if($this->Helper->isAdmin()) {
                if (!empty($_POST['action']) and !empty($_POST['users'])) {
                    foreach ($_POST['users'] as $valeur) {
                        if ($_POST['action'] == 'setAdmin') {
                            $this->userManager->setAdmin($valeur);
                        }
                        if ($_POST['action'] == 'revokeAdmin') {
                            $this->userManager->revokeAdmin($valeur);
                        }
                        if ($_POST['action'] == 'restrict') {
                            $this->userManager->restrictUser($valeur);
                        }
                        if ($_POST['action'] == 'revokeRestrict') {
                            $this->userManager->revokeRestrict($valeur);
                        }
                    }
                    $this->executeUsers();
                } else {
                    $this->executeUsers();
                }
            } else {
                echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
            }
        }else{
            header('Location: users');
        }
    }

}