<?php
namespace Tom\Blog\Controller;


class ContactController extends Controller{

    private $helper;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new \Tom\Blog\Services\Helper();
    }

    private function sendMail(String $visitor_email, String $visitor_message, String $visitor_name)
    {
        if ($_SESSION['contact_token'] == $_POST['token']) {
            $message = '';
            if (!$this->helper->isEmail($visitor_email)) {
                $message = '<p>Adresse e-mail invalide</p>';
            }
            if (strlen($visitor_email) > 254) {
                $message = $message . '<p class="msg_error">La taille maximum de l\'email est de 254 caractères ! </p>';
            }
            if (strlen($visitor_message) > 16384) {
                $message = $message . '<p class="msg_error">La taille maximum du message est de 16384 caractères ! </p>';
            }
            if (strlen($visitor_name) > 90) {
                $message = $message . '<p class="msg_error">La taille maximum du nom est de 90 caractères ! </p>';
            }

            if (empty($message)) {
                if ($this->helper->mail($_POST['mail'], $_POST['message'], $_POST['nom'])) {
                    $message = '<div class="alert alert-success" role="alert"><strong>Votre message à bien été envoyé ! Je vous répondrais dans les plus brefs délais </strong></div>';
                } else {
                    $message = '<div class="alert alert-danger" role="alert"><strong>Désolé le message n\'a pas pu être envoyé</strong></div>';
                }
            } else {
                $message = '<div class="alert alert-danger" role="alert"><strong>' . $message . '</strong></div>';
            }

            return $message;
        }else{
            header('Location: contact');
        }
    }

    public function executeSendMail(){
        if(!empty($_POST['nom']) and !empty($_POST['mail']) and !empty($_POST['message'])) {
            $msg = $this->sendMail($_POST['mail'], $_POST['message'], $_POST['nom']);
            echo $this->twig->render('contact.twig', ['message' => $msg]);
        }else{
            echo $this->twig->render('contact.twig');
        }
    }

}