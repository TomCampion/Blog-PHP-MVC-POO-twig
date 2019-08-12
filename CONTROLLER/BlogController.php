<?php
namespace Tom\Blog\Controller;

class BlogController extends Controller{

    private $PostManager;

    public function __construct()
    {
        parent::__construct();
        $this->PostManager = new \Tom\Blog\Model\PostManager();
    }

    public function executePost($params){
        $post = $this->PostManager->get($params['id']);
        echo  $this->twig->render('post.twig', ['post' => $post ] );
    }

    public function executeBlog(){
        $publishedPosts = $this->PostManager->getPublishedPosts();
        echo  $this->twig->render('blog.twig', ['publishedPosts' => $publishedPosts ]);
    }

}