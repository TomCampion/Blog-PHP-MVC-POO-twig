<?php
require 'vendor/autoload.php';

session_start();

// Routing
$router = new AltoRouter();
$router->setBasePath('/blog');
$router->map('GET','/','accueil');
$router->map('GET','/accueil', 'accueil');
$router->map('GET','/a_propos', 'a_propos');
$router->map('GET','/cv', 'cv');
$router->map('GET','/portfolio', 'portfolio');
$router->map('GET','/projet1', 'projet1');
$router->map('GET','/blog', 'blog');
$router->map('GET','/connexion', 'connexion');
$router->map('GET','/contact', 'contact');
$router->map('GET','/profil', 'profil');

$router->map('GET','/post-[i:id]', 'post');

$FrontendController = new Tom\Blog\Controller\FrontendController();
$BlogController = new Tom\Blog\Controller\BlogController();
$SecurityController = new Tom\Blog\Controller\SecurityController();

$match = $router->match();
$target = $match['target'];

if($target == 'connexion' or $target == 'profil'){
    $SecurityController->execute($match);
}elseif($target == 'blog' or $target == 'post'){
    $BlogController->execute($match);
}else{
    $FrontendController->execute($match);
}