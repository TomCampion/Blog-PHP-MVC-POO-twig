<?php

class BlogController extends tom\controller\Controller{

    private $PostManager;

    public function __construct()
    {
       parent::__construct();
       $this->PostManager = new PostManager(); 
    }

    public function renderPost($params){
        $post = $this->PostManager->get($params['id']);       
        echo  $this->twig->render('post.twig', ['post' => $post ] );  
    }


    public function renderBlog(){
        $publishedPosts = $this->PostManager->getPublishedPosts();
        echo  $this->twig->render('blog.twig', ['publishedPosts' => $publishedPosts ]);  
    }

}