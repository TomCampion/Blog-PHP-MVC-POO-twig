<?php
namespace Tom\Blog\Model;

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

    public function get( int $id ){
        try {
            $query = $this->db->prepare('SELECT * FROM users WHERE id=?');
            $query->execute( array($id) );
            $user = $query->fetch();
            return $user;
        } catch (Exception $e) {
            echo 'Impossible de selectionner l\'utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function getList(){
        try {
            $query = $this->db->prepare('SELECT * FROM users');
            $query->execute();
            $users = $query->fetchAll();
            return $users;
        } catch (Exception $e) {
            echo 'Impossible de selectionner les utilisateurs : '.$e->getMessage().'<br>';
        }
    }

    public function removeAdmin (Users $usr){
        try {
            $query = $this->db->prepare('UPDATE users SET admin=0 WHERE id=?');
            $query->execute( array($usr->getId()) );
        } catch (Exception $e) {
            echo 'Impossible de retirer le role admin : '.$e->getMessage().'<br>';
        }
    }

    public function setAdmin (Users $usr){
        try {
            $query = $this->db->prepare('UPDATE users SET admin=1 WHERE id=?');
            $query->execute( array($usr->getId()) );
        } catch (Exception $e) {
            echo 'Impossible de mettre le role admin : '.$e->getMessage().'<br>';
        }
    }

    public function restrictUser (Users $usr){
        try {
            $query = $this->db->prepare('UPDATE users SET restricted=1 WHERE id=?');
            $query->execute( array($usr->getId()) );
        } catch (Exception $e) {
            echo 'Impossible de restreindre l\utilisateur : '.$e->getMessage().'<br>';
        }
    }

    public function unRestrictuser (Users $usr){
        try {
            $query = $this->db->prepare('UPDATE users SET restricted=0 WHERE id=?');
            $query->execute( array($usr->getId()) );
        } catch (Exception $e) {
            echo 'Impossible d\'enlever la restriction : '.$e->getMessage().'<br>';
        }
    }

    public function isEmailUnique($email)
    {
        $valid = true;
        $db = new \PDO('mysql:host='.getenv("DB_HOST").';dbname='.getenv("DB_NAME").';charset=utf8', ''.getenv("DB_USER").'', ''.getenv("DB_PASSWORD").'');
        $query = $db->prepare('SELECT id FROM users WHERE email=?');
        $query->execute( array($email) );
        $record = $query->fetch();

        if ($record) {
            $valid = false;
        }
        return $valid;
    }

    public function userExist (String $email, String $password){
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