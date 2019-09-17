<?php
namespace Tom\Blog\Model;

use PDO;

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

    public function getList(String $table, String $column = NULL, String $order = NULL, int $page, int $nbrpost ){
        try {
            if($column == NULL and $order == NULL){
                $column = 'id';
                $order = 'ASC';
            }
            if($column == 'id' or $column == 'title' or $column == 'author' or $column == 'state' or $column == 'standfirst' or $column == 'creationDate' or $column == 'updateDate') {
                if($order == 'ASC' or $order == 'DESC') {
                    $query = $this->db->prepare("SELECT * FROM $table ORDER BY :column :order LIMIT :offset, :limit");
                    (int)$offset = $page*$nbrpost-$nbrpost;
                    //$query->bindParam(':table',  $table, PDO::PARAM_STR);
                    $query->bindParam(':column',  $column, PDO::PARAM_STR);
                    $query->bindParam(':order', $order, PDO::PARAM_STR);
                    $query->bindParam(':offset',  $offset, PDO::PARAM_INT);
                    $query->bindParam(':limit', $nbrpost, PDO::PARAM_INT);
                    $query->execute();
                    $users = $query->fetchAll();
                    return $users;
                }else{
                    throw new Exception("Impossible d'effectuer un tri par ordre : ".$order);
                }
            }else{
                throw new Exception("Impossible d'effectuer un tri sur la colonne : ".$column);
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner les posts : '.$e->getMessage().'<br>';
        }
    }
}