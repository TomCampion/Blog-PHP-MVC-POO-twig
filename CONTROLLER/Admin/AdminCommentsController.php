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

    public function executeChangeCommentState(){
        if(!empty($_SESSION['admin']) and $_SESSION['admin'] == 1) {
            if (!empty($_POST['state']) and !empty($_POST['comments'])) {
                foreach($_POST['comments'] as $valeur)
                {
                    if($_POST['state'] == 'valid'){
                        $state = \Tom\Blog\Model\Comments::VALID;
                    }elseif($_POST['state'] == 'invalid'){
                        $state = \Tom\Blog\Model\Comments::INVALID;
                    }
                    $this->CommentManager->changeState($state, $valeur);
                }
            }
            $this->executeComments();
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    public function executeDeleteComment($params){
        if(!empty($_SESSION['admin']) and $_SESSION['admin'] == 1) {
            $post = $this->CommentManager->delete($params['id']);
            header('Location: comments');
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

}