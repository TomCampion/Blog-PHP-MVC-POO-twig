<?php
namespace Tom\Blog\Model;

Class Users {

    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $admin;
    private $restricted;

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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        if (is_string($firstname) && strlen($firstname) <= 45)
            $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        if (is_string($lastname) && strlen($lastname) <= 45)
            $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) != false && strlen($email) <= 254)
            $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        if (is_string($password) && strlen($password) <= 254)
            $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     *
     * @return self
     */
    public function setAdmin($admin)
    {
        $admin = (int)$admin;
        $this->admin = $admin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRestricted()
    {
        return $this->restricted;
    }

    /**
     * @param mixed $restricted
     *
     * @return self
     */
    public function setRestricted($restricted)
    {
        $restricted = (int)$restricted;
        $this->restricted = $restricted;
        return $this;
    }
}