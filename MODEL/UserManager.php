<?php
namespace Tom\Blog\Model;

use Exception;
use PDO;

Class UserManager extends Manager {

    public function add( Users $usr ){
        try {
            $query = $this->db->prepare('INSERT INTO users(firstname, lastname, email, password, admin, restricted, register_date) VALUES(?, ?, ?, ?, ?, ?, NOW())');
            $query->execute( array($usr->getFirstname(), $usr->getLastname(), $usr->getEmail(), $usr->getPassword(), $usr->getAdmin(), $usr->getRestricted()) );
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            echo 'Impossible d\ajouter l\'utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function delete( Users $usr ){
        try {
            $query = $this->db->prepare('DELETE FROM users WHERE id=?');
            $query->execute( array($usr->getId()) );
        } catch (Exception $e) {
            echo 'Impossible de supprimmer l\'utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function update (String $firstname, String $lastname, String $email, int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET firstname= ?, lastname= ?, email= ? WHERE id= ?');
            $query->execute( array($firstname, $lastname, $email, $id) );
        } catch (Exception $e) {
            echo 'Impossible de modifier l\'utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function updatePassword(String $password, int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET password= ? WHERE id= ?');
            $query->execute( array(password_hash($password, PASSWORD_ARGON2I), $id) );
        } catch (Exception $e) {
            echo 'Impossible de modifier le mot de passe : '.$e->getMessage().'<br>';
        }
    }

    public function get( int $id ){
        try {
            if($id > 0){
                $query = $this->db->prepare('SELECT * FROM users WHERE id=?');
                $query->execute( array($id) );
                $user = $query->fetch();
                return $user;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner l\'utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function getList(String $column = NULL, String $order = NULL){
        try {
            if($column == NULL and $order == NULL){
                $column = 'id';
                $order = 'ASC';
            }
            if($column == 'id' or $column == 'firstname' or $column == 'lastname' or $column == 'email' or $column == 'restricted' or $column == 'admin' or $column == 'register_date') {
                if($order == 'ASC' or $order == 'DESC') {
                    $query = $this->db->prepare("SELECT * FROM users ORDER BY $column $order");
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
            echo 'Impossible de selectionner les utilisateurs : '.$e->getMessage().'<br>';
        }
    }

    public function revokeAdmin (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET admin=0 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            echo 'Impossible de retirer le role admin : '.$e->getMessage().'<br>';
        }
    }

    public function setAdmin (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET admin=1 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            echo 'Impossible de mettre le role admin : '.$e->getMessage().'<br>';
        }
    }

    public function restrictUser (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET restricted=1 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            echo 'Impossible de restreindre l\utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function revokeRestrict (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET restricted=0 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            echo 'Impossible d\'enlever la restriction : '.$e->getMessage().'<br>';
        }
    }

    public function isEmailUnique(String $email)
    {
        try {
            $valid = true;
            $db = new PDO('mysql:host='.getenv("DB_HOST").';dbname='.getenv("DB_NAME").';charset=utf8', ''.getenv("DB_USER").'', ''.getenv("DB_PASSWORD").'');
            $query = $db->prepare('SELECT id FROM users WHERE email=?');
            $query->execute( array($email) );
            $record = $query->fetch();

            if ($record) {
                $valid = false;
            }
            return $valid;
        } catch (Exception $e) {
            echo 'Impossible d\'enlever la restriction : '.$e->getMessage().'<br>';
        }
    }

    public function authenticate(String $email, String $password){
        try {
            $query = $this->db->prepare('SELECT * FROM users WHERE email=?');
            $query->execute( array($email) );
            $user = $query->fetch();

            if($user != false && password_verify($password, $user->password )){
                return $user;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo 'Impossible de vérifer l\'existence de l\'utilisateur : '.$e->getMessage().'<br>';
        }
    }

}