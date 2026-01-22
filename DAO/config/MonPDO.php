<?php

class MonPDO{

    private const HOST_NAME = "localhost";
    
    private const DB_NAME = "ticket_management";

    private const USER_NAME = "root";

    private const PDW = "";

    private static $monPDOinstance= null;

    public static function getPDO(){

   // PATERN SINGLETON

   if (is_null(self::$monPDOinstance)){

   // creéer la connexion
    try{

        $options =array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $url= "mysql:host=".self::HOST_NAME. "; dbname=".self::DB_NAME;

        self::$monPDOinstance= new PDO($url, self::USER_NAME, self::PDW);
        
    }
    catch(PDOException $e){
        $message= "Erreur de connexion à la db". $e->getMessage();
        die($message);

    }

   }
   
   //renvoyer l'intance de la connexion qui existe déja

    return self::$monPDOinstance;
    
    }

}