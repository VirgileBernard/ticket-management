<?php
require_once __DIR__ . '/../Controllers/DeviceController.php';
session_start();

$_SESSION['flash-message delete'] = "L'appareil a été supprimé";

if (!isset($_POST['id_device'])){
    die ('ID device manquant');
}

$device_id = intval($_POST['id_device']);

DeviceController::deleteDevice($device_id);

header('Location: ../views/materiel.php');
exit;