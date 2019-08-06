<?php

class SecurityController extends tom\controller\Controller{

	public function renderConnexion(){		
        echo  $this->twig->render('connexion.twig');  
    }
  
}