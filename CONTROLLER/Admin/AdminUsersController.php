<?php
namespace Tom\Blog\AdminController;

class AdminUsersController extends AdminController{

    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    public function executeUsers(){
        if(!empty($_POST['sort']) and !empty($_POST['order'])){
            $users = $this->userManager->sortUsers($_POST['sort'], $_POST['order']);
        }else{
            $users = $this->userManager->getList();
        }
        echo  $this->twig->render('users.twig', ['users' => $users ] );
    }

}