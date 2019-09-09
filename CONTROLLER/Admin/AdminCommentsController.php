<?php
namespace Tom\Blog\AdminController;

class AdminCommentsController extends \Tom\Blog\Controller\Controller{

    private $CommentManager;
    private $Helper;

    public function __construct()
    {
        parent::__construct('backend');
        $this->CommentManager = new \Tom\Blog\Model\CommentManager();
        $this->Helper = new \Tom\Blog\Services\Helper();
    }

    public function executeComments(){
        if(!empty($_SESSION['admin']) and $this->Helper->isAdmin($_SESSION['admin'])) {
            if (!empty($_POST['sort']) and !empty($_POST['order']) and $_SESSION['sortComments_token'] == $_POST['token']) {
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
        if ($_SESSION['commentState_token'] == $_POST['tokenState']) {
            if(!empty($_SESSION['admin']) and $this->Helper->isAdmin($_SESSION['admin'])) {
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
        }else{
            header('Location: comments');
        }
    }

    public function executeDeleteComment(){
        if ($_SESSION['deleteComment_token'] == $_POST['token']) {
            if(!empty($_SESSION['admin']) and $this->Helper->isAdmin($_SESSION['admin'])) {
                $post = $this->CommentManager->delete($_POST['comment_id']);
                header('Location: comments');
            }else{
                echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
            }
        }else{
            header('Location: comments');
        }
    }

}