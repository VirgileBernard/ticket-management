<?php

class Status{
    private $id_status;
    private $nom;


    public function __construct($id_status, $nom){
        $this->id_status=$id_status;
        $this->nom=$nom;
    }

    public function getIdStatus(){
        return $this->id_status;
    }

    public function getNom(){
        return $this->nom;
    }
}