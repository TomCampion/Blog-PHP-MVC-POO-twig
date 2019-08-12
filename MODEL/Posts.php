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
     * @return self
     */
    public function setId($id)
    {
        $id = (int)$id;
        $this->id = $id;

        return $this;
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
     * @return self
     */
    public function setTitle($title)
    {
        if (is_string($title) && strlen($title) <= 100)
            $this->title = $title;

        return $this;
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
     * @return self
     */
    public function setAuthor($author)
    {
        if (is_string($author) && strlen($author) <= 45)
            $this->author = $author;

        return $this;
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
     * @return self
     */
    public function setStandfirst($standfirst)
    {
        if (is_string($standfirst) && strlen($standfirst) <= 255)
            $this->standfirst = $standfirst;

        return $this;
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
     * @return self
     */
    public function setContent($content)
    {
        if (is_string($content))
            $this->content = $content;

        return $this;
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
     * @return self
     */
    public function setCreationDate($creationDate)
    {
        if(is_string($creationDate)){
            $creationDate = date( "Y-m-d", strtotime( $creationDate ) );
            $this->creationDate = $creationDate;
        }

        return $this;
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
     * @return self
     */
    public function setUpdateDate($updateDate)
    {
        if(is_string($updateDate)){
            $updateDate = date( "Y-m-d", strtotime( $updateDate ) );
            $this->updateDate = $updateDate;
        }

        return $this;
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
     * @return self
     */
    public function setState($state)
    {
        if($state == 'draft' or $state == 'published' or $state == 'trash'){
            $this->state = $state;
        }

        return $this;
    }
}