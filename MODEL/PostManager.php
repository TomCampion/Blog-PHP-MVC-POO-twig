<?php

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

	public function delete( Posts $post ){
		try {
			$query = $this->db->prepare('DELETE FROM posts WHERE id=?');
			$query->execute( array($post->getId()) );			
		} catch (Exception $e) {
			echo 'Impossible de supprimmer le post : '.$e->getMessage().'<br>';
		}
	}

	public function get( int $id ){
		try {
			$query = $this->db->prepare('SELECT * FROM posts WHERE id=?');
			$query->execute( array($id) );
			$post = $query->fetch();	
			return $post;			
		} catch (Exception $e) {
			echo 'Impossible de selectionner le post : '.$e->getMessage().'<br>';
		}
	}

	public function getList(){
		try {
			$query = $this->db->prepare('SELECT * FROM posts');
			$query->execute();
			$posts = $query->fetchAll();
			return $posts;			
		} catch (Exception $e) {
			echo 'Impossible de selectionner les posts : '.$e->getMessage().'<br>';
		}
	}

	public function update (Posts $post){
		try {
			$query = $this->db->prepare('UPDATE posts SET title= ?, author= ?, standfirst= ?, content= ?, creationDate= ?, updateDate= NOW(), state= ? WHERE id= ?');
			$query->execute( array($post->getTitle(), $post->getAuthor(), $post->getStandfirst(), $post->getContent(), $post->getCreationDate(), $post->getState()) );			
		} catch (Exception $e) {
			echo 'Impossible de modifier le post : '.$e->getMessage().'<br>';
		}
	}

	public function getPublishedPosts(){
		try {
			$query = $this->db->prepare('SELECT * FROM posts WHERE state=\'published\'');
			$query->execute();
			$posts = $query->fetchAll();
			return $posts;			
		} catch (Exception $e) {
			echo 'Impossible de selectionner les posts publiés : '.$e->getMessage().'<br>';
		}
	}

}