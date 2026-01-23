<?php

class Role{
    private $id;
    private $name;

    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    //Getters

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function __toString() {
        return sprintf(
            "Role [id=%s, name=%s]",
            $this->id ?? 'null',
            $this->name
        );
    } 

}