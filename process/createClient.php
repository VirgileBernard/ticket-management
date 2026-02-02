<?php
require_once __DIR__ . '/../Controllers/ClientController.php';
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can create clients
AccessControl::requireSupervisor();

if(
    !isset($_POST['lname']) ||
    !isset($_POST['fname']) ||
    !isset($_POST['email']) ||
    !isset($_POST['phone'])
){
    die("Champs manquants");
}

$client = new Client(
    null,
    $_POST['lname'],
    $_POST['fname'],
    $_POST['email'],
    $_POST['phone']
);

$newId = ClientController::createClient($client);

$_SESSION['flash_message_success'] = "Client créé avec succès";


// var_dump($_SESSION);
// exit;

header("Location: " . BASE_URL . "views/clients.php");
exit;
