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
$ContactController = new Controller\ContactController();
$AdminUsersController = new AdminController\AdminUsersController();
$AdminPostsController = new AdminController\AdminPostsController();
$AdminCommentsController = new AdminController\AdminCommentsController();

$router->setBasePath('/blog');
$router->map('GET','/', [$FrontendController, "executeAccueil"]);
$router->map('GET','/accueil', [$FrontendController, "executeAccueil"]);
$router->map('GET','/a_propos', [$FrontendController, "executeA_propos"]);
$router->map('GET','/cv', [$FrontendController, "executeCv"]);
$router->map('GET','/portfolio', [$FrontendController, "executePortfolio"]);
$router->map('GET','/meilleursyndic', [$FrontendController, "executeProjet1"]);
$router->map('GET','/maisonaudiocenter', [$FrontendController, "executeProjet2"]);
$router->map('GET','/izyhealth', [$FrontendController, "executeProjet3"]);
$router->map('GET','/dblleroux', [$FrontendController, "executeProjet4"]);
$router->map('GET','/immobilier', [$FrontendController, "executeProjet5"]);
$router->map('GET','/blog', [$BlogController, "executeBlog"]);
$router->map('GET','/connexion', [$SecurityController, "executeLoginPage"]);
$router->map('GET','/contact', [$FrontendController, "executeContact"]);
$router->map('GET','/profil', [$ProfileController, "executeProfil"]);

$router->map('GET','/post-[i:id]', [$BlogController, "executePost"]);

$router->map('POST','/contact', [$ContactController, "executeSendMail"]);
$router->map('POST','/post-[i:id]', [$BlogController, "executeAddComment"]);
$router->map('GET|POST','/editComment-[i:id]', [$BlogController, "executeEditComment"]);
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
$router->map('GET|POST','/deletePost', [$AdminPostsController, "executeDeletePost"]);
$router->map('GET|POST','/comments', [$AdminCommentsController, "executeComments"]);
$router->map('POST','/changeCommentState', [$AdminCommentsController, "executeChangeCommentState"]);
$router->map('GET|POST','/deleteComment', [$AdminCommentsController, "executeDeleteComment"]);


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