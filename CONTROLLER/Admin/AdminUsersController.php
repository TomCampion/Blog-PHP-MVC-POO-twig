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
        $users = $this->userManager->getList();
        echo  $this->twig->render('users.twig', ['users' => $users ] );
    }

}