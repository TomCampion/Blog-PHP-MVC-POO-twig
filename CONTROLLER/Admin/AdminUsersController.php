<?php
namespace Tom\Blog\AdminController;
use Tom\Blog\Services\Session;

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
            if (!empty(filter_input(INPUT_POST, 'sort')) and !empty(filter_input(INPUT_POST, 'order')) and Session::get('sortUsers_token') == filter_input(INPUT_POST, 'token')) {
                $users = $this->userManager->getList("users",filter_input(INPUT_POST, 'sort'), filter_input(INPUT_POST, 'order'),(int)$params['page'] , $nbrpost);
            } else {
                $users = $this->userManager->getList("users",null, null, (int)$params['page'] , $nbrpost);
            }
            $this->twig->display('users.twig', ['users' => $users, 'page'=> (int)$params['page'], 'nbr_pages'=> $nbr_pages ]);
        }else{
            $this->twig->display('403.twig');
        }
    }

    public function executeUserAction(){
        if (Session::get('usersAction_token') == filter_input(INPUT_POST, 'token')) {
            if($this->Helper->isAdmin()) {
                if (!empty(filter_input(INPUT_POST, 'action')) and !empty(filter_input(INPUT_POST, 'users',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY))) {
                    foreach (filter_input(INPUT_POST, 'users',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $valeur) {
                        if (filter_input(INPUT_POST, 'action') == 'setAdmin') {
                            $this->userManager->setAdmin($valeur);
                        }
                        if (filter_input(INPUT_POST, 'action') == 'revokeAdmin') {
                            $this->userManager->revokeAdmin($valeur);
                        }
                        if (filter_input(INPUT_POST, 'action') == 'restrict') {
                            $this->userManager->restrictUser($valeur);
                        }
                        if (filter_input(INPUT_POST, 'action') == 'revokeRestrict') {
                            $this->userManager->revokeRestrict($valeur);
                        }
                    }
                    $this->executeUsers();
                } else {
                    $this->executeUsers();
                }
            } else {
                $this->twig->display('403.twig');
            }
        }else{
            header('Location: users');
        }
    }

}
