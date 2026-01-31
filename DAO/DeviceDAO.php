<?php

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Device.php';

class DeviceDAO{
public static function getDevices(){
    $con = MONPDO::getPDO();
    $requete = "
        SELECT
            d.id_device,
            d.model,
            d.serial_number,
            d.client_id,
            d.brand,
            d.type_id,
            d.submission_date,
            d.retrieve_date,
            t.nom AS type_nom,
            CONCAT(c.fname, ' ', c.lname) AS client_name
        FROM devices d
        JOIN clients c ON d.client_id = c.id_client
        JOIN types t ON t.id_type = d.type_id
    ";

    $stmt = $con->prepare($requete);    
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $devices = [];

    foreach ($rows as $row) {

        // On stocke l'objet dans une variable
        $device = new Device(
            $row['id_device'],
            $row['model'],
            $row['serial_number'],
            $row['brand'],
            $row['type_id'],
            $row['client_id'],
            $row['submission_date'],
            $row['retrieve_date'],
        );

        // On ajoute la propriété supplémentaire
        $device->client_name = $row['client_name'];
        $device->type_nom = $row['type_nom'];

        // On push l'objet final dans le tableau
        $devices[] = $device;
    }

    return $devices;
}

// créer un device
public static function createDevice($device){
    $con = MONPDO::getPDO();

    $requete = "
        INSERT INTO devices 
            (model, serial_number, brand, type_id, client_id, submission_date, retrieve_date)
        VALUES 
            (:model, :serial_number, :brand, :type_id, :client_id, :submission_date, :retrieve_date)
    ";

    $stmt = $con->prepare($requete);

    $stmt->bindValue(":model", $device->getModel(), PDO::PARAM_STR);
    $stmt->bindValue(":serial_number", $device->getSerialNumber(), PDO::PARAM_STR);
    $stmt->bindValue(":brand", $device->getBrandName(), PDO::PARAM_STR);
    $stmt->bindValue(":type_id", $device->getType(), PDO::PARAM_INT);
    $stmt->bindValue(":client_id", $device->getClientId(), PDO::PARAM_INT);
    $stmt->bindValue(":submission_date", $device->getSubmissionDate(), PDO::PARAM_STR);
    $stmt->bindValue(":retrieve_date", $device->getRetrieveDate(), PDO::PARAM_STR);

    $stmt->execute();

    return $con->lastInsertId();
}



    //ouvrir un device par son id
public static function getDevice($id_device){
    $con = MONPDO::getPDO();

    $requete = "
        SELECT
            d.id_device,
            d.model,
            d.serial_number,
            d.client_id,
            d.brand,
            d.type_id,
            d.submission_date,
            d.retrieve_date,
            t.nom AS type_nom,
            CONCAT(c.fname, ' ', c.lname) AS client_name
        FROM devices d
        JOIN clients c ON d.client_id = c.id_client
        JOIN types t ON t.id_type = d.type_id
        WHERE d.id_device = :id_device
    ";

    $stmt = $con->prepare($requete);
    $stmt->bindValue(":id_device", $id_device, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    $device = new Device(
        $row['id_device'],
        $row['model'],
        $row['serial_number'],
        $row['brand'],
        $row['type_id'],
        $row['client_id'],
        $row['submission_date'],
        $row['retrieve_date'],
    );

    $device->type_nom = $row['type_nom'];
    $device->client_name = $row['client_name'];


    return $device;
}

// function pour update un device
    static function updateDevice($device){
        $con = MONPDO::getPDO();
        $stmt = $con->prepare("
        UPDATE devices 
                               
        SET model = :model, 
            serial_number = :serial_number, 
            brand = :brand, 
            type_id = :type_id, 
            client_id = :client_id, 
            submission_date = :submission_date, 
            retrieve_date = :retrieve_date
        WHERE id_device = :id_device");

             $stmt->bindValue(":id_device",$device->getIdDevice(),PDO::PARAM_INT);
        $stmt->bindValue(":model",$device->getModel(),PDO::PARAM_STR);
        $stmt->bindValue(":serial_number",$device->getSerialNumber(),PDO::PARAM_STR);
        $stmt->bindValue(":brand",$device->getBrandName(),PDO::PARAM_STR);
        $stmt->bindValue(":type_id",$device->getType(),PDO::PARAM_INT);
        $stmt->bindValue(":client_id",$device->getClientId(),PDO::PARAM_INT);
        $stmt->bindValue(":submission_date",$device->getSubmissionDate(),PDO::PARAM_STR);
        $stmt->bindValue(":retrieve_date",$device->getRetrieveDate(),PDO::PARAM_STR);

        $stmt->execute();
    }

    // function pour delete un device
    public static function deleteDevice($id_device){
    $con = MONPDO::getPDO();
    $stmt = $con->prepare("DELETE
    FROM
    devices
    WHERE
    id_device = :id_device");
    $stmt->bindValue(":id_device", $id_device, PDO::PARAM_INT);
    return $stmt->execute();
    }

                               
    }

