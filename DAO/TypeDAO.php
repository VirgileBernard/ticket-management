<?php

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Type.php';

class TypeDAO{

public static function getTypes(){
    $con=MONPDO::getPDO();
    $requete = "SELECT
    id_type, nom
    FROM
    types";
    $stmt=$con->prepare($requete);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $types=[];
    foreach ($rows as $row){
        $types[]= new Type(
            $row['id_type'],
            $row['nom']
        );
    }
    return $types;
}
}