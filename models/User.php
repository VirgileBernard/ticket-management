<?php
class User {

    public $id;
    private $fname;
    private $lname;
    private $email;
    private $phone_number;
    private $password;
    private $role_id;

    public function __construct($id, $fname, $lname, $email, $phone_number, $password=null, $role_id) {
        $this->id = $id;
        $this->fname = $fname;   
        $this->lname = $lname;
        $this->email = $email;
        $this->phone_number = $phone_number;
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

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getRoleId() {
        return $this->role_id;
    }
    public function getPassword(){
        return $this->password;
    }
    public function __toString() {
        return sprintf(
            "User [id=%s, fname=%s, lname=%s, email=%s, phone_number=%s, role_id=%s]",
            $this-> id,
            $this->fname,
            $this->lname,
            $this->email,
            $this->phone_number,
            $this->role_id
        );
    }
}
