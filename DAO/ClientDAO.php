<?php

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Client.php';

class ClientDAO{

    // obtenir tous les clients
    public static function getClients(){
        $con=MONPDO::getPDO();
        $requete = "SELECT id_client, fname, lname, email, phone_number FROM clients";
        $stmt = $con->prepare($requete);    
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clients = [];
        foreach ($rows as $row) {
            $clients[] = new Client(
                $row['id_client'],
                $row['fname'],
                $row['lname'],
                $row['email'],
                $row['phone_number']
            );
        }
        return $clients;
    }
    
    // obtenir un client par son id
    public static function getClient($id_client){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT * FROM clients WHERE id_client = :id_client");
        $stmt->bindValue(":id_client", $id_client, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //créer un nouveau client
    static function createClient($client){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("INSERT INTO clients (fname, lname, email, phone_number) 
                              VALUES (:fname, :lname, :email, :phone_number)");
        
        $stmt->bindValue(":fname",$client->getFname(),PDO::PARAM_STR);
        $stmt->bindValue(":lname",$client->getLname(),PDO::PARAM_STR);
        $stmt->bindValue(":email",$client->getEmail(),PDO::PARAM_STR);
        $stmt->bindValue(":phone_number",$client->getphone(),PDO::PARAM_STR);
        
        $stmt->execute();
    }

    //ouvrir un client
    static function openClient($client_id){
        $con=MONPDO::getPDO();
       $requete = "
       SELECT 
           c.id_client,
           c.fname,
           c.lname,
           c.email,
           c.phone_number
         FROM clients c
            WHERE c.id_client = :client_id
         ";
           
         $stmt = $con->prepare($requete);
         $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
         $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        $client = new Client(
            $rows['id_client'],
            $rows['fname'],
            $rows['lname'],
            $rows['email'],
            $rows['phone_number']
        );

        return $client;
    }


    //update un client
    static function updateClient($client){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("UPDATE clients 
                               SET fname = :fname, lname = :lname, email = :email, phone_number = :phone_number
                               WHERE id_client = :id_client");
        
        $stmt->bindValue(":fname",$client->getFname(),PDO::PARAM_STR);
        $stmt->bindValue(":lname",$client->getLname(),PDO::PARAM_STR);
        $stmt->bindValue(":email",$client->getEmail(),PDO::PARAM_STR);
        $stmt->bindValue(":phone_number",$client->getphone(),PDO::PARAM_STR);
        $stmt->bindValue(":id_client",$client->getId(),PDO::PARAM_INT);
        
        $stmt->execute();
    }

}