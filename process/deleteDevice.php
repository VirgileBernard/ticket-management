<?php
require_once __DIR__ . '/../Controllers/DeviceController.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can delete devices
AccessControl::requireSupervisor();

$_SESSION['flash-message delete'] = "L'appareil a été supprimé";

if (!isset($_POST['id_device'])){
    die ('ID device manquant');
}

$device_id = intval($_POST['id_device']);

DeviceController::deleteDevice($device_id);

header('Location: ../views/materiel.php');
exit;