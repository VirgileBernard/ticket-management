<?php
require_once '../Controllers/ClientController.php';
require_once '../Models/Client.php';
require_once '../DAO/config/Baseurl.php';
require_once '../helpers/AccessControl.php';

session_start();

// Only supervisors can update clients
AccessControl::requireSupervisor();
$_SESSION['flash-message edit'] = "Les informations du client ont été mises à jour avec succès.";

$client = new Client(
    $_POST['id_client'],
    $_POST['fname'],
    $_POST['lname'],
    $_POST['email'],
    $_POST['phone_number']
);

ClientController::updateClient($client);

header("Location: " . BASE_URL . "views/clients.php");
 exit;

