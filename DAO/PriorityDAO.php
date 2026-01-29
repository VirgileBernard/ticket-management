<?php 

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Priority.php';

class PriorityDAO{

//obtenir toutes les priorités
public static function getPrioritys(){
    $con=MONPDO::getPDO();
    $requete = "SELECT
    id_priority, nom
    FROM
    priorities";
    $stmt=$con->prepare($requete);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $prioritys = [];
    foreach ($rows as $row){
        $prioritys[]= new Priority(
            $row['id_priority'],
            $row['nom']
        );
    }
    return $prioritys;
}
}