<?php
require 'config.php';

class Manager
{
	protected $db;

	function __construct() {
        $this->dbConnect();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    private function dbConnect()
    {
    	try{
	        $this->db = new PDO('mysql:host='.getenv("DB_HOST").';dbname='.getenv("DB_NAME").';charset=utf8', ''.getenv("DB_USER").'', ''.getenv("DB_PASSWORD").'');
	    }catch(Exception $e){
	    	echo 'Echec de la connection à la base de donnée : '.$e->getMessage().'<br>';
	    }

	    return $this->db;
    }

}
