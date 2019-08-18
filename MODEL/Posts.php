<?php
namespace Tom\Blog\Model;

Class Posts {

    private $id;
    private $title;
    private $author;
    private $standfirst;
    private $content;
    private $creationDate;
    private $updateDate;
    private $state;

    const PUBLISHED = 'published';
    const TRASH = 'trash';
    const DRAFT = 'draft';

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return void
     */
    public function setId($id)
    {
        $id = (int)$id;
        if($id > 0){
            $this->id = $id;
        }else{
            throw new \Exception("User id can not be < 0");
        }
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return void
     */
    public function setTitle($title)
    {
        if (is_string($title)){
            if(strlen($title) <= 100){
                $this->title = $title;
            }else{
                throw new \Exception("The maximum length of the title is 100 characters");
            }
        }else{
            throw new \Exception("Firstname must be a String");
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
     *
     * @return void
     */
    public function setAuthor($author)
    {
        if (is_string($author)){
            if(strlen($author) <= 45){
                $this->author = $author;
            }else{
                throw new \Exception("The maximum length of the author attribute is 45 characters");
            }
        }else{
            throw new \Exception("Author attribute must be a String");
        }
    }

    /**
     * @return mixed
     */
    public function getStandfirst()
    {
        return $this->standfirst;
    }

    /**
     * @param mixed $standfirst
     *
     * @return void
     */
    public function setStandfirst($standfirst)
    {
        if (is_string($standfirst)){
            if(strlen($standfirst) <= 255){
                $this->standfirst = $standfirst;
            }else{
                throw new \Exception("The maximum length of the standfirst is 255 characters");
            }
        }else{
            throw new \Exception("Standfirst must be a String");
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
     *
     * @return void
     */
    public function setContent($content)
    {
        if (is_string($content)){
            if(strlen($content) <= 65535){
                $this->content = $content;
            }else{
                throw new \Exception("The maximum length of the content is 65535 characters");
            }
        }else{
            throw new \Exception("Content must be a String");
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
     */
    public function setState($state)
    {
        if($state === self::DRAFT or $state === self::PUBLISHED  or $state === self::TRASH ){
            $this->state = $state;
        }else{
            throw new \Exception("State attribute must be equal to 'draft', 'published' or 'trash'");
        }
    }
}