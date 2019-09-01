<?php
require 'vendor/autoload.php';

use Tom\Blog\Controller as Controller;
use Tom\Blog\AdminController as AdminController;

session_start();

// Routing
$router = new AltoRouter();
$FrontendController = new Controller\FrontendController();
$BlogController = new Controller\BlogController();
$SecurityController = new Controller\SecurityController();
$ProfileController = new Controller\ProfileController();
$AdminUsersController = new AdminController\AdminUsersController();
$AdminPostsController = new AdminController\AdminPostsController();

$router->setBasePath('/blog');
$router->map('GET','/', [$FrontendController, "executeAccueil"]);
$router->map('GET','/accueil', [$FrontendController, "executeAccueil"]);
$router->map('GET','/a_propos', [$FrontendController, "executeA_propos"]);
$router->map('GET','/cv', [$FrontendController, "executeCv"]);
$router->map('GET','/portfolio', [$FrontendController, "executePortfolio"]);
$router->map('GET','/projet1', [$FrontendController, "executeProjet1"]);
$router->map('GET','/blog', [$BlogController, "executeBlog"]);
$router->map('GET','/connexion', [$SecurityController, "executeLoginPage"]);
$router->map('GET','/contact', [$FrontendController, "executeContact"]);
$router->map('GET','/profil', [$ProfileController, "executeProfil"]);

$router->map('GET','/post-[i:id]', [$BlogController, "executePost"]);

$router->map('POST','/post-[i:id]', [$BlogController, "executeAddComment"]);
$router->map('POST','/register', [$SecurityController, "executeRegister"]);
$router->map('POST','/authentification', [$SecurityController, "executeAuthentification"]);
$router->map('POST','/logout', [$SecurityController, "executeLogout"]);
$router->map('POST','/editprofile', [$ProfileController, "executeEditProfile"]);
$router->map('POST','/changePassword', [$ProfileController, "executeChangePassword"]);

//Admin part
$router->map('GET|POST','/users', [$AdminUsersController, "executeUsers"]);
$router->map('POST','/usersAction', [$AdminUsersController, "executeUserAction"]);
$router->map('GET|POST','/posts', [$AdminPostsController, "executePosts"]);
$router->map('GET|POST','/add_post', [$AdminPostsController, "executeAddPost"]);
$router->map('GET|POST','/editPost-[i:id]', [$AdminPostsController, "executeEditPost"]);
$router->map('GET|POST','/deletePost-[i:id]', [$AdminPostsController, "executeDeletePost"]);

$match = $router->match();

if($match && is_callable($match['target'])) {
    if(!empty($match['params'])){
        call_user_func($match['target'], $match['params']);
    }else{
        call_user_func($match['target']);
    }
} else {
    $FrontendController->execute404();
}