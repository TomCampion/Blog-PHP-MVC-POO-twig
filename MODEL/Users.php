<?php
namespace Tom\Blog\Model;

Class Users extends Entity {

    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $admin;
    private $restricted;

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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     *
     * @return void
     */
    public function setFirstname($firstname)
    {
        if (is_string($firstname)){
            if(strlen($firstname) <= 45){
                $this->firstname = $firstname;
            }else{
                throw new \Exception("The maximum length of the firstname is 45 characters");
            }
        }else{
            throw new \Exception("Firstname must be a String");
        }
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
     * @return void
     */
    public function setLastname($lastname)
    {
        if (is_string($lastname)){
            if(strlen($lastname) <= 45){
                $this->lastname = $lastname;
            }else{
                throw new \Exception("The maximum length of the lastname is 45 characters");
            }
        }else{
            throw new \Exception("Lastname must be a String");
        }
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
     * @return void
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) != false ) {
            if (strlen($email) <= 254) {
                $this->email = $email;
            }else{
                throw new \Exception("The maximum length of the email is 254 characters");
            }
        }else{
            throw new \Exception("invalid email format");
        }

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
     * @return void
     */
    public function setPassword($password)
    {
        if (is_string($password)){
            if (strlen($password) <= 254) {
                $this->password = $password;
            }else{
                throw new \Exception("The maximum length of the password is 254 characters");
            }
        }else{
            throw new \Exception("Password must be a String");
        }
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
     * @return void
     */
    public function setAdmin($admin)
    {
        $admin = (int)$admin;
        if($admin === 0 or $admin === 1){
            $this->admin = $admin;
        }else{
            throw new \Exception("Admin attribute must be 0 or 1");
        }
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
     * @return void
     */
    public function setRestricted($restricted)
    {
        $restricted = (int) $restricted;
        if( $restricted === 0 or  $restricted === 1){
            $this->restricted =  $restricted;
        }else{
            throw new \Exception("Restricted attribute must be 0 or 1");
        }

    }

}