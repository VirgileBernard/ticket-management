<?php
require_once __DIR__ . '/../Controllers/DeviceController.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can create devices
AccessControl::requireSupervisor();

if (
    !isset($_POST['model']) ||
    !isset($_POST['serial_number']) ||
    !isset($_POST['brand']) ||
    !isset($_POST['type_id']) ||
    !isset($_POST['client_id']) ||
    !isset($_POST['submission_date'])
) {
    die("Champs manquants");
}

$device = new Device(
    null,
    $_POST['model'],
    $_POST['serial_number'],
    $_POST['brand'],
    $_POST['type_id'],
    $_POST['client_id'],
    $_POST['submission_date'],
    $_POST['retrieve_date'] ?? null
);

$newId = DeviceController::createDevice($device);

$_SESSION['flash_message_success'] = "Appareil créé avec succès";


// var_dump($_SESSION);
// exit;

header("Location: " . BASE_URL . "views/materiel.php");
exit;
