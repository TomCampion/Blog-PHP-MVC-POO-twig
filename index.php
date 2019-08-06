<?php
require 'vendor/autoload.php';
require 'CONTROLLER/Controller.php';
require 'CONTROLLER/SecurityController.php';
require 'CONTROLLER/FrontendController.php';
require 'CONTROLLER/BlogController.php';

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

$router->map('POST','/connexion', 'connexion');

$FrontendController = new FrontendController();
$BlogController = new BlogController();
$SecurityController = new SecurityController();

$match = $router->match();

if($match['target'] == 'connexion' or $match['target'] == 'profil'){
	$SecurityController->render($match);
}elseif($match['target'] == 'blog' or $match['target'] == 'post'){
	$BlogController->render($match);	
}else{
	$FrontendController->render($match);	
}