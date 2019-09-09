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

    public function executePosts(){
        if(!empty($_SESSION['admin']) and $this->Helper->isAdmin($_SESSION['admin'])) {
            if (!empty($_POST['sort']) and !empty($_POST['order']) and $_SESSION['sortPosts_token'] == $_POST['token']) {
                $posts = $this->postManager->getList($_POST['sort'], $_POST['order']);
            } else {
                $posts = $this->postManager->getList();
            }
            echo $this->twig->render('posts.twig', ['posts' => $posts]);
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    private function addPost(String $title, String $standfirst, String $content, String $state){
        if ($_SESSION['addPost_token'] == $_POST['token']) {
            $data = [
                'title' => $title,
                'standfirst' => $standfirst,
                'content' => $content,
                'state' => $state,
                'author' => $_SESSION['firstname'] . ' ' . $_SESSION['lastname']
            ];
            $post = new \Tom\Blog\Model\Posts();
            $post->hydrate($data);
            $this->postManager->add($post);
        }else{
            header('Location: add_post');
        }
    }

    public function executeAddPost(){
        if(!empty($_SESSION['admin']) and $this->Helper->isAdmin($_SESSION['admin'])) {
            if(!empty($_POST['title']) and !empty($_POST['standfirst']) and !empty($_POST['content']) and !empty($_POST['state'])){
                $this->addPost($_POST['title'], $_POST['standfirst'], $_POST['content'], $_POST['state']);
                header('Location: posts');
            }else{
                echo $this->twig->render('addPost.twig');
            }
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    private function editPost(int $id, String $title, String $standfirst, String $content, String $state, String $author){
        if ($_SESSION['editPost_token'] == $_POST['token']) {
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
        if($this->Helper->isAdmin($_SESSION['admin'])) {
            if(!empty($params['id']) and !empty($_POST['title']) and !empty($_POST['standfirst']) and !empty($_POST['content']) and !empty($_POST['state'])){
                $this->editPost($params['id'], $_POST['title'], $_POST['standfirst'], $_POST['content'], $_POST['state'], $_POST['author']);
                header('Location: posts');
            }else{
                $post = $this->postManager->get($params['id']);
                echo $this->twig->render('editPost.twig', ['post' => $post ]);
            }
        }else{
            echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
        }
    }

    public function executeDeletePost(){
        if ($_SESSION['deletePost_token'] == $_POST['token']) {
            if($this->Helper->isAdmin($_SESSION['admin'])) {
                $post = $this->postManager->delete($_POST['post_id']);
                header('Location: posts');
            }else{
                echo '<h4>Vous devez être connecté avec un compte administrateur pour accéder à cette page ! <a href="connexion">Connectez-vous !</a> </h4>';
            }
        }else{
            header('Location: posts');
        }
    }

}