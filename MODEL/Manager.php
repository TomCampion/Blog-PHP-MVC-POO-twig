<?php
namespace Tom\Blog\Model;

use PDO;
use Exception;

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
            throw new Exception('Echec de la connection à la base de donnée : '.$e->getMessage());
        }
        return $this->db;
    }

    public function getList(String $table, String $column = NULL, String $order = NULL, int $page, int $nbrpost ){
        try {
            if($column == NULL and $order == NULL){
                $column = 'id';
                $order = 'ASC';
            }
            if($column == 'id' or $column == 'title' or $column == 'author' or $column == 'state' or $column == 'standfirst' or $column == 'creationDate' or $column == 'updateDate' or $column == 'content' or $column == 'user_id' or $column == 'post_id' or $column == 'firstname' or $column == 'lastname' or $column == 'email' or $column == 'admin' or $column == 'restricted' or $column == 'register_date' ) {
                if($order == 'ASC' or $order == 'DESC') {
                    $query = $this->db->prepare("SELECT * FROM $table ORDER BY $column $order LIMIT :offset, :limit");
                    (int)$offset = $page*$nbrpost-$nbrpost;
                    $query->bindParam(':offset',  $offset, PDO::PARAM_INT);
                    $query->bindParam(':limit', $nbrpost, PDO::PARAM_INT);
                    $query->execute();
                    $data = $query->fetchAll();
                    return $data;
                }else{
                    throw new Exception("Impossible d'effectuer un tri par ordre : ".$order);
                }
            }else{
                throw new Exception("Impossible d'effectuer un tri sur la colonne : ".$column);
            }
        } catch (Exception $e) {
            throw new Exception('Impossible de selectionner les posts : '.$e->getMessage());
        }
    }
}