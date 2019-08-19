<?php
require 'vendor/autoload.php';

session_start();

// Routing
$router = new AltoRouter();

$FrontendController = new Tom\Blog\Controller\FrontendController();
$BlogController = new Tom\Blog\Controller\BlogController();
$SecurityController = new Tom\Blog\Controller\SecurityController();
$AdminUserController = new Tom\Blog\AdminController\AdminUsersController();

$router->setBasePath('/blog');
$router->map('GET','/', [$FrontendController, "executeAccueil"]);
$router->map('GET','/accueil', [$FrontendController, "executeAccueil"]);
$router->map('GET','/a_propos', [$FrontendController, "executeA_propos"]);
$router->map('GET','/cv', [$FrontendController, "executeCv"]);
$router->map('GET','/portfolio', [$FrontendController, "executePortfolio"]);
$router->map('GET','/projet1', [$FrontendController, "executeProjet1"]);
$router->map('GET','/blog', [$BlogController, "executeBlog"]);
$router->map('GET','/connexion', [$SecurityController, "executeConnexion"]);
$router->map('GET','/contact', [$FrontendController, "executeContact"]);
$router->map('GET','/profil', [$SecurityController, "executeProfil"]);

$router->map('GET','/post-[i:id]', [$BlogController, "executePost"]);

$router->map('POST','/register', [$SecurityController, "executeRegister"]);
$router->map('POST','/authentification', [$SecurityController, "executeAuthentification"]);
$router->map('POST','/logout', [$SecurityController, "executeLogout"]);
$router->map('POST','/editprofile', [$SecurityController, "executeEditProfile"]);
//Admin part
$router->map('GET','/users', [$AdminUserController, "executeUsers"]);

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