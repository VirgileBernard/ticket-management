<?php

class Client{
    private  $id;
    private $fname;
    private $lname; 
    private $email;
    private $phone;
    
    function __construct($id, $fname, $lname, $email, $phone){
        $this->id=$id;
        $this->fname=$fname;
        $this->lname=$lname;
        $this->email=$email;
        $this->phone=$phone;
    }

    //Getters

    public function getId(){
        return $this->id;
    }

    public function getFname(){
        return $this->fname;
    }

    public function getLname(){
        return $this->lname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function __toString() {
        return sprintf(
            "Client [id=%s, fname=%s, lname=%s, email=%s, phone=%s]",
            $this->id ?? 'null',
            $this->fname,
            $this->lname,
            $this->email,
            $this->phone
        );
    }
    

}

