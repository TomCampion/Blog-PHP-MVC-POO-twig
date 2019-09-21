<?php
namespace Tom\Blog\AdminController;

class AdminPostsController extends \Tom\Blog\Controller\Controller{

    private $postManager;
    private $Helper;

    public function __construct()
    {
        parent::__construct('backend');
        $this->postManager = new \Tom\Blog\Model\PostManager();
        $this->Helper = new \Tom\Blog\Services\Helper();
    }

    public function executePosts($params = null){
        $nbrpost = 10;
        $nbr_pages = ceil($this->postManager->getPostsNumber()/$nbrpost);

        if(empty($params['page'])){
            $params['page'] = 1;
        }
        if($params['page']  > $nbr_pages){
            $params['page']  = ceil($this->postManager->getPostsNumber()/$nbrpost);
        }
        if($this->Helper->isAdmin()) {
            if (!empty(filter_input(INPUT_POST, 'sort')) and !empty(filter_input(INPUT_POST, 'order')) and $_SESSION['sortUsers_token'] == filter_input(INPUT_POST, 'token')) {
                $posts = $this->postManager->getList("posts",filter_input(INPUT_POST, 'sort'), filter_input(INPUT_POST, 'order'),(int)$params['page'] , $nbrpost);
            } else {
                $posts = $this->postManager->getList("posts",null, null, (int)$params['page'] , $nbrpost);
            }
            echo $this->twig->render('posts.twig', ['posts' => $posts, 'page'=> (int)$params['page'], 'nbr_pages'=> $nbr_pages ]);
        }else{
            echo $this->twig->render('403.twig');
        }
    }

    private function addPost(String $title, String $standfirst, String $content, String $state){
        if (!empty(filter_input(INPUT_POST, 'token')) && $_SESSION['addPost_token'] == filter_input(INPUT_POST, 'token')) {
            $data = [
                'title' => $title,
                'standfirst' => $standfirst,
                'content' => $content,
                'state' => $state,
                'author' => $_SESSION['firstname']. ' ' .$_SESSION['lastname']
            ];
            $post = new \Tom\Blog\Model\Posts();
            $post->hydrate($data);
            $this->postManager->add($post);
        }else{
            header('Location: add_post');
        }
    }

    public function executeAddPost(){
        if($this->Helper->isAdmin()) {
            if(!empty(filter_input(INPUT_POST, 'title')) and !empty(filter_input(INPUT_POST, 'standfirst')) and !empty(filter_input(INPUT_POST, 'content')) and !empty(filter_input(INPUT_POST, 'state'))){
                $this->addPost(filter_input(INPUT_POST, 'title'), filter_input(INPUT_POST, 'standfirst'), filter_input(INPUT_POST, 'content'), filter_input(INPUT_POST, 'state'));
                header('Location: posts');
            }else{
                echo $this->twig->render('addPost.twig');
            }
        }else{
            echo $this->twig->render('403.twig');
        }
    }

    private function editPost(int $id, String $title, String $standfirst, String $content, String $state, String $author){
        if (!empty(filter_input(INPUT_POST, 'token')) && $_SESSION['editPost_token'] == filter_input(INPUT_POST, 'token')) {
            $data = [
                'id' => $id,
                'title' => $title,
                'standfirst' => $standfirst,
                'content' => $content,
                'state' => $state,
                'author' => $author
            ];
            $post = new \Tom\Blog\Model\Posts();
            $post->hydrate($data);
            $this->postManager->update($post);
        }else{
            header('Location: add_post');
        }
    }

    public function executeEditPost($params){
        if($this->Helper->isAdmin()) {
            if(!empty($params['id']) and !empty(filter_input(INPUT_POST, 'title')) and !empty(filter_input(INPUT_POST, 'standfirst')) and !empty(filter_input(INPUT_POST, 'content')) and !empty(filter_input(INPUT_POST, 'state'))){
                $this->editPost($params['id'], filter_input(INPUT_POST, 'title'), filter_input(INPUT_POST, 'standfirst'), filter_input(INPUT_POST, 'content'), filter_input(INPUT_POST, 'state'), filter_input(INPUT_POST, 'author'));
                header('Location: posts');
            }else{
                $post = $this->postManager->get($params['id']);
                echo $this->twig->render('editPost.twig', ['post' => $post ]);
            }
        }else{
            echo $this->twig->render('403.twig');
        }
    }

    public function executeDeletePost(){
        if (!empty(filter_input(INPUT_POST, 'post_id')) && $_SESSION['deletePost_token'] == filter_input(INPUT_POST, 'token')) {
            if($this->Helper->isAdmin($_SESSION['admin'])) {
                $post = $this->postManager->delete(filter_input(INPUT_POST, 'post-id'));
                header('Location: posts');
            }else{
                echo $this->twig->render('403.twig');
            }
        }else{
            header('Location: posts');
        }
    }

}