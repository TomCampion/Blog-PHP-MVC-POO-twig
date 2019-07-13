<?php
require 'vendor/autoload.php';

require_once('Controller/ControllerComment.php');
require_once ('Controller/ControllerMember.php');
require_once ('Controller/ControllerPost.php');

// Rendu du template
$loader = new Twig_Loader_Filesystem(__DIR__ . '/VIEW');
$twig = new Twig_Environment($loader, [
    //'cache' => __DIR__ . '/tmp',
    'debug' => true
]);

$twig->addExtension(new Twig_Extension_Debug());
//var_dump($_GET);
// Routing 
$page = "accueil";
if(isset($_GET['url']))$page = $_GET['url'];


switch ($page) {
    case 'accueil':
        echo $twig->render('accueil.twig');
        break;
    case 'a_propos':
        echo $twig->render('a_propos.twig');
        break;
    case 'cv':
        echo $twig->render('cv.twig');
        break;
	case 'portfolio':
        echo $twig->render('portfolio.twig');
        break;
    case 'projet-1':
        echo $twig->render('projet1.twig');
        break;
    case 'contact':
        echo $twig->render('contact.twig');
        break;
    case 'blog':
        echo $twig->render('blog.twig');
        break;
    case (preg_match('#article-([0-9]+)#', $page, $params) ? true : false):
        echo $twig->render('article.twig', ['id_article' => $params[1] ]);
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
        break;
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



