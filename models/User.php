<?php
class User {

    private $id;
    private $fname;
    private $lname;
    private $email;
    private $phone;
    private $password;
    private $role_id;

    public function __construct($id, $fname, $lname, $email, $phone, $password=null, $role_id) {
        $this->id = $id;
        $this->fname = $fname;   
        $this->lname = $lname;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->role_id = $role_id;
    }

    // Getters
    public function getIdUser() {
        return $this->id;
    }

    public function getFname() {
        return $this->fname;
    }

    public function getLname() {
        return $this->lname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getRoleId() {
        return $this->role_id;
    }
    public function getPassword(){
        return $this->password;
    }
    public function __toString() {
        return sprintf(
            "User [id=%s, fname=%s, lname=%s, email=%s, phone=%s, role_id=%s]",
            $this-> id,
            $this->fname,
            $this->lname,
            $this->email,
            $this->phone,
            $this->role_id
        );
    }
}
