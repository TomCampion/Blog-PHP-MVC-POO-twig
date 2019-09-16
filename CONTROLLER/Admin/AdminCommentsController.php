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

    public function executeComments($params = null){
        $nbrpost = 10;
        $nbr_pages = ceil($this->CommentManager->getCommentsNumber()/$nbrpost);

        if(empty($params['page'])){
            $params['page'] = 1;
        }
        if($params['page']  > $nbr_pages){
            $params['page']  = ceil($this->CommentManager->getCommentsNumber()/$nbrpost);
        }
        if($this->Helper->isAdmin()) {
            if (!empty($_POST['sort']) and !empty($_POST['order']) and $_SESSION['sortUsers_token'] == $_POST['token']) {
                $comments = $this->CommentManager->getList("comments",$_POST['sort'], $_POST['order'],(int)$params['page'] , $nbrpost);
            } else {
                $comments = $this->CommentManager->getList("comments",null, null, (int)$params['page'] , $nbrpost);
            }
            echo $this->twig->render('comments.twig', ['comments' => $comments, 'page'=> (int)$params['page'], 'nbr_pages'=> $nbr_pages ]);
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    public function executeChangeCommentState(){
        if ($_SESSION['commentState_token'] == $_POST['tokenState']) {
            if($this->Helper->isAdmin()) {
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
            if($this->Helper->isAdmin()) {
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