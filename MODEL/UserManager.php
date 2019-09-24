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
            throw new Exception('Impossible d\ajouter l\'utilisateur : '.$e->getMessage());
        }
    }

    public function delete( Users $usr ){
        try {
            $query = $this->db->prepare('DELETE FROM users WHERE id=?');
            $query->execute( array($usr->getId()) );
        } catch (Exception $e) {
            throw new Exception('Impossible de supprimmer l\'utilisateur : '.$e->getMessage());
        }
    }

    public function update (String $firstname, String $lastname, String $email, int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET firstname= ?, lastname= ?, email= ? WHERE id= ?');
            $query->execute( array($firstname, $lastname, $email, $id) );
        } catch (Exception $e) {
            throw new Exception('Impossible de modifier l\'utilisateur : '.$e->getMessage());
        }
    }

    public function updatePassword(String $password, int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET password= ? WHERE id= ?');
            $query->execute( array(password_hash($password, PASSWORD_ARGON2I), $id) );
        } catch (Exception $e) {
            throw new Exception('Impossible de modifier le mot de passe : '.$e->getMessage());
        }
    }

    public function getUsersNumber(){
        try {
            $query = $this->db->prepare("SELECT COUNT(*) FROM users ");
            $query->execute();
            $usersNumber = $query->fetchColumn();
            return (int)$usersNumber;
        } catch (Exception $e) {
            throw new Exception('Impossible de selectionner les utilisateurs publiés : '.$e->getMessage());
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
            throw new Exception('Impossible de selectionner l\'utilisateur : '.$e->getMessage());
        }
    }

    public function revokeAdmin (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET admin=0 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            throw new Exception('Impossible de retirer le role admin : '.$e->getMessage());
        }
    }

    public function setAdmin (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET admin=1 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            throw new Exception('Impossible de mettre le role admin : '.$e->getMessage());
        }
    }

    public function restrictUser (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET restricted=1 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            throw new Exception('Impossible de restreindre l\utilisateur : '.$e->getMessage());
        }
    }

    public function revokeRestrict (int $id){
        try {
            $query = $this->db->prepare('UPDATE users SET restricted=0 WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            throw new Exception('Impossible d\'enlever la restriction : '.$e->getMessage());
        }
    }

    public function isEmailUnique(String $email)
    {
        try {
            $valid = true;
            $query = $this->db->prepare('SELECT id FROM users WHERE email=?');
            $query->execute( array($email) );
            $record = $query->fetch();
            if ($record) {
                $valid = false;
            }
            return $valid;
        } catch (Exception $e) {
            throw new Exception('Impossible de vérifié l\'unicité de l\'email : '.$e->getMessage());
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
            throw new Exception('Impossible de vérifer l\'existence de l\'utilisateur : '.$e->getMessage());
        }
    }

}