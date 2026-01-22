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
    public function getFname(){
        return $this->fname;
    }
    

}

