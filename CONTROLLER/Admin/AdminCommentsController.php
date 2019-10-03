<?php
namespace Tom\Blog\AdminController;
use Tom\Blog\Services\Session;

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
            if (!empty(filter_input(INPUT_POST, 'sort')) and !empty(filter_input(INPUT_POST, 'order')) and Session::get('sortComments_token') == filter_input(INPUT_POST, 'token')) {
                $comments = $this->CommentManager->getList("comments",filter_input(INPUT_POST, 'sort'), filter_input(INPUT_POST, 'order'),(int)$params['page'] , $nbrpost);
            } else {
                $comments = $this->CommentManager->getList("comments",null, null, (int)$params['page'] , $nbrpost);
            }
            $this->twig->display('comments.twig', ['comments' => $comments, 'page'=> (int)$params['page'], 'nbr_pages'=> $nbr_pages ]);
        }else{
            $this->twig->display('403.twig');
        }
    }

    public function executeChangeCommentState(){
        if (!empty(filter_input(INPUT_POST, 'tokenState')) && Session::get('commentState_token') == filter_input(INPUT_POST, 'tokenState')) {
            if($this->Helper->isAdmin()) {
                if (!empty(filter_input(INPUT_POST, 'state')) and !empty(filter_input(INPUT_POST, 'comments',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY))) {
                    foreach(filter_input(INPUT_POST, 'comments',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $valeur)
                    {
                        if(filter_input(INPUT_POST, 'state') == 'valid'){
                            $state = \Tom\Blog\Model\Comments::VALID;
                        }elseif(filter_input(INPUT_POST, 'state') == 'invalid'){
                            $state = \Tom\Blog\Model\Comments::INVALID;
                        }
                        $this->CommentManager->changeState($state, $valeur);
                    }
                }
                $this->executeComments();
            }else{
                $this->twig->display('403.twig');
            }
        }else{
            header('Location: comments');
        }
    }

    public function executeDeleteComment(){
        if (!empty(filter_input(INPUT_POST, 'comment_id')) && Session::get('deleteComment_token') == filter_input(INPUT_POST, 'token')) {
            if($this->Helper->isAdmin()) {
                $this->CommentManager->delete(filter_input(INPUT_POST, 'comment_id'));
                header('Location: comments');
            }else{
                $this->twig->display('403.twig');
            }
        }else{
            header('Location: comments');
        }
    }

}