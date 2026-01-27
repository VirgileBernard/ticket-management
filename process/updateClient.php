<?php
require_once '../Controllers/ClientController.php';
require_once '../Models/Client.php';
require_once '../DAO/config/Baseurl.php';

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

