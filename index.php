<?php
require 'vendor/autoload.php';
require_once 'Controller/BlogController.php';

// Routing 
require_once 'Services/Router.php';


$router = new AltoRouter();
$router->setBasePath('/Blog');
$router->map('GET','/', 'accueil');
$router->map('GET','/accueil', 'accueil');
$router->map('GET','/a_propos', 'a_propos');
$router->map('GET','/cv', 'cv');
$router->map('GET','/portfolio', 'portfolio');
$router->map('GET','/projet1', 'projet1');
$router->map('GET','/blog', 'blog');
$router->map('GET','/connexion', 'connexion');
$router->map('GET','/contact', 'contact');

$router->map('GET','/post-[i:id]', 'post');
// match current request
$match = $router->match();

$blogController = new BlogController();
if($match['target'] == 'post'){
    $blogController->renderPost($match['params']['id']);
}else{
    $blogController->render($match['target']);
}

// Récupère les derniers tutoriels
/**controller**
function tutoriels () {
    $pdo = new PDO('mysql:dbname=grafikart_dev;host=localhost', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $tutoriels = $pdo->query('SELECT * FROM tutoriels ORDER BY id DESC LIMIT 10');
    return $tutoriels;
}
*/



