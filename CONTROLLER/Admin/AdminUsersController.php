<?php
namespace Tom\Blog\AdminController;

class AdminUsersController extends Controller{

    private $userManager;

    public function __construct()
    {
        parent::__construct('backend');
        $this->userManager = new \Tom\Blog\Model\UserManager();
    }

    public function executeUsers(){
        $users = $this->userManager->getList();
        echo  $this->twig->render('users.twig', ['users' => $users ] );
    }

}