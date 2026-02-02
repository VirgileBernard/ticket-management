<?php

// var_dump($_POST);
// exit;
require_once '../Controllers/DeviceController.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can update devices
AccessControl::requireSupervisor();
$_SESSION['flash-message edit'] = "Les informations de l'appareil ont été mises à jour avec succès.";



$device = new Device(
    $_POST['id_device'],
    $_POST['model'],
    $_POST['serial_number'],
    $_POST['brand'],
    $_POST['type_id'],
    $_POST['client_id'],
    $_POST['submission_date'],
    $_POST['retrieve_date']
);

DeviceController::updateDevice($device);

header("Location: " . BASE_URL . "views/materiel.php");
 exit;