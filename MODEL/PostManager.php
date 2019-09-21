<?php
namespace Tom\Blog\Model;

use Exception;
use Tom\Blog\Model\Posts;
use PDO;

Class PostManager extends Manager {

    public function add( Posts $post ){
        try {
            $query = $this->db->prepare('INSERT INTO posts(title, author, standfirst, content, creationDate, updateDate, state) VALUES(?, ?, ?, ?, NOW(), ?, ?)');
            $query->execute( array($post->getTitle(), $post->getAuthor(), $post->getStandfirst(), $post->getContent(),  $post->getUpdateDate(), $post->getState()) );
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            echo 'Impossible d\ajouter le post : '.$e->getMessage().'<br>';
        }
    }

    public function delete( int $id ){
        try {
            $query = $this->db->prepare('DELETE FROM posts WHERE id=?');
            $query->execute( array($id) );
        } catch (Exception $e) {
            echo 'Impossible de supprimmer le post : '.$e->getMessage().'<br>';
        }
    }

    public function get( int $id ){
        try {
            if( $id > 0 ){
                $query = $this->db->prepare('SELECT * FROM posts WHERE id=?');
                $query->execute( array($id) );
                $post = $query->fetch();
                return $post;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo 'Impossible de selectionner le post : '.$e->getMessage().'<br>';
        }
    }

    public function update (Posts $post){
        try {
            $query = $this->db->prepare('UPDATE posts SET title= ?, author= ?, standfirst= ?, content= ?, updateDate= NOW(), state= ? WHERE id= ?');
            $query->execute( array($post->getTitle(), $post->getAuthor(), $post->getStandfirst(), $post->getContent(), $post->getState(), $post->getId() ));
        } catch (Exception $e) {
            echo 'Impossible de modifier le post : '.$e->getMessage().'<br>';
        }
    }

    public function getPostsNumber(){
        try {
        $query = $this->db->prepare("SELECT COUNT(*) FROM posts ");
        $query->execute();
        $postsNumber = $query->fetchColumn();
        return (int)$postsNumber;
    } catch (Exception $e) {
        echo 'Impossible de selectionner les posts publiés : '.$e->getMessage().'<br>';
        }
    }


    public function getPublishedPosts( int $page, int $nbrpost ){
        try {
            $query = $this->db->prepare("SELECT * FROM posts WHERE state= :state ORDER BY creationDate DESC LIMIT :offset, :limit");
            (int)$offset = $page*$nbrpost-$nbrpost;
            (string)$state = Posts::PUBLISHED;
            $query->bindParam(':offset',  $offset, PDO::PARAM_INT);
            $query->bindParam(':limit', $nbrpost, PDO::PARAM_INT);
            $query->bindParam(':state', $state, PDO::PARAM_STR);
            $query->execute();
            $posts = $query->fetchAll();
            return $posts;
        } catch (Exception $e) {
            echo 'Impossible de selectionner les posts publiés : '.$e->getMessage().'<br>';
        }
    }

}