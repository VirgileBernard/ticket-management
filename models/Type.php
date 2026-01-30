<?php

class Type{
    private $id_type;
    private $nom;

    public function __construct($id_type, $nom){
        $this->id_type=$id_type;
        $this->nom=$nom;
    }

    public function getIdType(){
        return $this->id_type;
    }

    public function getNom(){
        return $this->nom;
    }
}