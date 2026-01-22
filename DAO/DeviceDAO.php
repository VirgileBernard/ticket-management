<?php

require_once "config/MonPDO.php";
require_once __DIR__ . '/../Models/Device.php';

class DeviceDAO{

//obtenir toutes les devices
    public static function getDevices(){
        $con=MONPDO::getPDO();
        $requete = "SELECT id_device, model, serial_number, client_id, brand, type_id, submission_date, retrieve_date FROM devices";
        $stmt = $con->prepare($requete);    
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $devices = [];
        foreach ($rows as $row) {
            $devices[] = new Device(
                $row['id_device'],
                $row['model'],
                $row['serial_number'],
                $row['client_id'],
                $row['brand'],
                $row['type_id'],
                $row['submission_date'],
                $row['retrieve_date']
            );
        }
        return $devices;
    }


    //obtenir un device par son id
    public static function getDevice($id_device){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT * FROM devices WHERE id_device = :id_device");
        $stmt->bindValue(":id_device", $id_device, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //créer un nouveau device
    static function createDevice($device){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("INSERT INTO devices (model, serial_number, brand, type_id, client_id, submission_date, retrieve_date) 
                              VALUES (:model, :serial_number, :brand, :type_id, :client_id, :submission_date, :retrieve_date)");
        
        $stmt->bindValue(":model",$device->getModel(),PDO::PARAM_STR);
        $stmt->bindValue(":serial_number",$device->getSerialNumber(),PDO::PARAM_STR);
        $stmt->bindValue(":brand",$device->getBrand(),PDO::PARAM_STR);
        $stmt->bindValue(":type_id",$device->getTypeId(),PDO::PARAM_INT);
        $stmt->bindValue(":client_id",$device->getClientId(),PDO::PARAM_INT);
        $stmt->bindValue(":submission_date",$device->getSubmissionDate(),PDO::PARAM_STR);
        $stmt->bindValue(":retrieve_date",$device->getRetrieveDate(),PDO::PARAM_STR);
        
        $stmt->execute();
    }
}