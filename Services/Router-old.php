<?php
require_once('Controller/frontendController.php');

class Router {

    private $url;
    private $routes = [];
    private $frontendcontroller;

    public function __construct($url){
        $this->url = $url;
        $this->frontendcontroller = new frontendcontroller();
    }

    public function addRoute($page){
        $this->routes[] = $page;
   	}

    public function searchMacthingRoute(){
    	$find = false;

        foreach($this->routes as $route){

			switch ($this->url) {
				
			    case $route:
			        $this->frontendcontroller->render($route);   
			        $find = true;
			        break 2;
			     
			    case (preg_match('#post-([0-9]+)#', $this->url, $params) ? true : false):
			    	
			    	var_dump($params[0]);
			        //$this->frontendcontroller->renderArticle($params[1]); 		        
			        $find = true;
			        break 2;    
			}       
		}

		if ($find == false){
	        $this->frontendcontroller->render('404');
	    }
	}

}