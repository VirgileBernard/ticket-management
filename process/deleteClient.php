<?php
require_once __DIR__ . '/../Controllers/ClientController.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can delete clients
AccessControl::requireSupervisor();

$_SESSION['flash-message delete'] = "Le client a été supprimé";

if(!isset($_POST['id_client'])){
    die ('ID client manquant');
}

$client_id = intval($_POST['id_client']);

ClientController::deleteClient($client_id);

header('Location: ../views/clients.php');
exit;