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
            throw new Exception('Impossible d\ajouter le commentaire : ' . $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $query = $this->db->prepare('DELETE FROM comments WHERE id=?');
            $query->execute(array($id));
        } catch (Exception $e) {
            throw new Exception('Impossible de supprimmer le commentaire : ' . $e->getMessage());
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
            throw new Exception('Impossible de selectionner le commentaire : ' . $e->getMessage());
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
            throw new Exception('Impossible de selectionner les commentaires du post '.$post_id.' : ' . $e->getMessage());
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
            throw new Exception('Impossible de selectionner les commentaires de l\'utilisateur '.$user_id.' : ' . $e->getMessage());
        }
    }

    public function getCommentsNumber(){
        try {
            $query = $this->db->prepare("SELECT COUNT(*) FROM comments ");
            $query->execute();
            $commentsNumber = $query->fetchColumn();
            return (int)$commentsNumber;
        } catch (Exception $e) {
            throw new Exception('Impossible de selectionner les commentaires publiés : '.$e->getMessage());
        }
    }

    public function update (Comments $comment){
        try {
            $query = $this->db->prepare('UPDATE comments SET content= ?, author =?, user_id= ?, post_id= ?, state= ?, updateDate= NOW() WHERE id= ?');
            $query->execute( array($comment->getContent(), $comment->getAuthor(), $comment->getUserId(), $comment->getPostId(), $comment->getState(), $comment->getId() ));
        } catch (Exception $e) {
            throw new Exception('Impossible de modifier le commentaire : '.$e->getMessage());
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
            throw new Exception('Impossible de modifier le commentaire : '.$e->getMessage());
        }
    }
}