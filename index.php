<?php
session_start();

require 'vendor/autoload.php';
require 'Controller/AppController.php';

// Routing 
$router = new AltoRouter();
$router->setBasePath('/tom');
$router->map('GET','/','accueil');
$router->map('GET','/accueil', 'accueil');
$router->map('GET','/a_propos', 'a_propos');
$router->map('GET','/cv', 'cv');
$router->map('GET','/portfolio', 'portfolio');
$router->map('GET','/projet1', 'projet1');
$router->map('GET','/blog', 'blog');
$router->map('GET','/connexion', 'connexion');
$router->map('GET','/contact', 'contact');

$router->map('GET','/post-[i:id]', 'post');

$router->map('POST','/connexion', 'connexion');
// match current request
$match = $router->match();

$AppController = new AppController();
$AppController->render($match);