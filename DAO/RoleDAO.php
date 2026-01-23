<?php

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Role.php';

class RoleDAO{
// obtenir tous les rôles
    public static function getRoles(){
        $con=MONPDO::getPDO();
        $requete = "SELECT id_role, nom FROM roles";
        $stmt = $con->prepare($requete);    
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $roles = [];
        foreach ($rows as $row) {
            $roles[] = new Role(
                $row['id_role'],
                $row['nom']
            );
        }
        return $roles;
    }


}