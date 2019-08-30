<?php
namespace Tom\Blog\AdminController;

class AdminPostsController extends \Tom\Blog\Controller\Controller{

    private $postManager;

    public function __construct()
    {
        parent::__construct('backend');
        $this->postManager = new \Tom\Blog\Model\PostManager();
    }

    public function executePosts(){
        if(!empty($_SESSION['admin']) and $_SESSION['admin'] == 1) {
            if (!empty($_POST['sort']) and !empty($_POST['order'])) {
                $posts = $this->postManager->sortPosts($_POST['sort'], $_POST['order']);
            } else {
                $posts = $this->postManager->getList();
            }
            echo $this->twig->render('posts.twig', ['posts' => $posts]);
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

}
