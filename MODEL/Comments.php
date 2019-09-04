<?php
namespace Tom\Blog\Model;

Class Comments extends Entity
{

    private $id;
    private $content;
    private $author;
    private $user_id;
    private $post_id;
    private $creationDate;
    private $updateDate;
    private $state;

    const VALID = 'valid';
    const WAITING_FOR_VALIDATION = 'waiting for validation';
    const INVALID = 'invalid';

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $id = (int)$id;
        if($id > 0){
            $this->id = $id;
        }else{
            throw new \Exception("Comment id can not be < 0");
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        if (is_string($content)){
            if(strlen($content) <= 1024){
                $this->content = $content;
            }else{
                throw new \Exception("The maximum length of the content is 1024 characters");
            }
        }else{
            throw new \Exception("Content must be a String");
        }
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        if (is_string($author)){
            if(strlen($author) <= 90){
                $this->author = $author;
            }else{
                throw new \Exception("The maximum length of the author attribute is 90 characters");
            }
        }else{
            throw new \Exception("Author attribute must be a String");
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $user_id = (int)$user_id;
        if($user_id > 0){
            $this->user_id = $user_id;
        }else{
            throw new \Exception("User id can not be < 0");
        }
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $post_id = (int)$post_id;
        if($post_id > 0){
            $this->post_id = $post_id;
        }else{
            throw new \Exception("Post id can not be < 0");
        }
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        if(is_string($creationDate)){
            $creationDate = date( "Y-m-d", strtotime( $creationDate ) );
            if($creationDate != '1970-01-01'){
                $this->creationDate = $creationDate;
            }else{
                throw new \Exception("Invalid date format for creationDate");
            }
        }else{
            throw new \Exception("creationDate must be a String");
        }
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param mixed $updateDate
     */
    public function setUpdateDate($updateDate)
    {
        if(is_string($updateDate)){
            $updateDate = date( "Y-m-d", strtotime( $updateDate ) );
            if($updateDate != '1970-01-01') {
                $this->updateDate = $updateDate;
            }else{
                throw new \Exception("Invalid date format for updateDate");
            }
        }else{
            throw new \Exception("updateDate must be a String");
        }
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        if($state === self::INVALID or $state === self::VALID  or $state === self::WAITING_FOR_VALIDATION ){
            $this->state = $state;
        }else{
            throw new \Exception("State attribute must be equal to 'valid', 'invalid' or 'waiting for validation'");
        }
    }

}