<?php
namespace Tom\Blog\AdminController;

class AdminCommentsController extends \Tom\Blog\Controller\Controller{

    private $CommentManager;

    public function __construct()
    {
        parent::__construct('backend');
        $this->CommentManager = new \Tom\Blog\Model\CommentManager();
    }

    public function executeComments(){
        if(!empty($_SESSION['admin']) and $_SESSION['admin'] == 1) {
            if (!empty($_POST['sort']) and !empty($_POST['order'])) {
                $comments = $this->CommentManager->getList($_POST['sort'], $_POST['order']);
            }else{
                $comments = $this->CommentManager->getList();
            }
            echo $this->twig->render('comments.twig', ['comments' => $comments]);
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }


}