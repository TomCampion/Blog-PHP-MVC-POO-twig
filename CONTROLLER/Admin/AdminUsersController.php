<?php
namespace Tom\Blog\AdminController;

class AdminUsersController extends \Tom\Blog\Controller\Controller{

    private $userManager;

    public function __construct()
    {
        parent::__construct('backend');
        $this->userManager = new \Tom\Blog\Model\UserManager();
        if($_SESSION['admin'] != 1) header();
    }

    public function executeUsers(){
        if(!empty($_POST['sort']) and !empty($_POST['order']) ){
            $users = $this->userManager->sortUsers($_POST['sort'], $_POST['order']);
        }else{
            $users = $this->userManager->getList();
        }
        echo  $this->twig->render('users.twig', ['users' => $users ] );
    }

}