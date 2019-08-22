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
}