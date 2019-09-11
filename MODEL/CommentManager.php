<?php
namespace Tom\Blog\Model;

use Exception;

Class CommentManager extends Manager
{

    public function add(Comments $comment)
    {
        try {
            $query = $this->db->prepare('INSERT INTO comments(content, author, user_id, post_id, state, creationDate, updateDate) VALUES(?, ?, ?, ?, ?, NOW(), ?)');
            $query->execute(array($comment->getContent(), $comment->getAuthor(), $comment->getUserId(), $comment->getPostId(), $comment->getState(), $comment->getUpdateDate()));
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            echo 'Impossible d\ajouter le commentaire : ' . $e->getMessage() . '<br>';
        }
    }

    public function delete(int $id)
    {
        try {
            $query = $this->db->prepare('DELETE FROM comments WHERE id=?');
            $query->execute(array($id));
        } catch (Exception $e) {
            echo 'Impossible de supprimmer le commentaire : ' . $e->getMessage() . '<br>';
        }
    }

    public function get(int $id)
    {
        try {
            if ($id > 0) {
                $query = $this->db->prepare('SELECT * FROM comments WHERE id=?');
                $query->execute(array($id));
                $comment = $query->fetchObject('\Tom\Blog\Model\Comments');
                return $comment;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner le commentaire : ' . $e->getMessage() . '<br>';
        }
    }

    public function getValidCommentsFromPost(int $post_id)
    {
        try {
            if ($post_id > 0) {
                $query = $this->db->prepare('SELECT * FROM comments WHERE post_id=? and state=\'valid\'');
                $query->execute(array($post_id));
                $comment = $query->fetchAll();
                return $comment;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner les commentaires du post '.$post_id.' : ' . $e->getMessage() . '<br>';
        }
    }

    public function getCommentsFromUser ( int $user_id, int $limit){
        try {
            if ($user_id > 0) {
                $query = $this->db->prepare("SELECT * FROM comments WHERE user_id=$user_id LIMIT $limit");
                $query->execute();
                $comment = $query->fetchAll();
                return $comment;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner les commentaires de l\'utilisateur '.$user_id.' : ' . $e->getMessage() . '<br>';
        }
    }

    public function getList(String $column = NULL, String $order = NULL)
    {
        try {
            if($column == NULL and $order == NULL){
                $column = 'id';
                $order = 'ASC';
            }
            if($column == 'id' or $column == 'content' or $column == 'author' or $column == 'user_id' or $column == 'post_id' or $column == 'state' or $column == 'creationDate' or $column == 'updateDate') {
                if($order == 'ASC' or $order == 'DESC') {
                    $query = $this->db->prepare("SELECT * FROM comments ORDER BY $column $order");
                    $query->execute();
                    $comments = $query->fetchAll();
                    return $comments;
                }else{
                    throw new Exception("Impossible d'effectuer un tri par ordre : ".$order);
                }
            }else{
                throw new Exception("Impossible d'effectuer un tri sur la colonne : ".$column);
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner les commentaires : ' . $e->getMessage() . '<br>';
        }
    }

    public function update (Comments $comment){
        try {
            $query = $this->db->prepare('UPDATE comments SET content= ?, author =?, user_id= ?, post_id= ?, state= ?, updateDate= NOW() WHERE id= ?');
            $query->execute( array($comment->getContent(), $comment->getAuthor(), $comment->getUserId(), $comment->getPostId(), $comment->getState(), $comment->getId() ));
        } catch (Exception $e) {
            echo 'Impossible de modifier le commentaire : '.$e->getMessage().'<br>';
        }
    }

    public function changeState (String $state, int $id){
        try {
            if($state == Comments::VALID or $state == Comments::INVALID){
                $query = $this->db->prepare('UPDATE comments SET state= ? WHERE id= ?');
                $query->execute( array($state, $id));
            }else{
                throw new Exception("Impossible de passer le statut du commentaire à : ".$state);
            }
        } catch (Exception $e) {
            echo 'Impossible de modifier le commentaire : '.$e->getMessage().'<br>';
        }
    }
}