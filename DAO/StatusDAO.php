<?php

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Status.php';

class StatusDAO{

//obtenir tous les status
public static function getStatus(){
    $con=MONPDO::getPDO();
    $requete = "SELECT
    id_status, nom
    FROM
    status";
    $stmt=$con->prepare($requete);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $status = [];
    foreach ($rows as $row){
        $status[]= new Status(
            $row['id_status'],
            $row['nom']
        );
    }
    return $status;
}

}