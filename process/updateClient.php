<?php
require_once '../Controllers/ClientController.php';
require_once '../Models/Client.php';

$client = new Client(
    $_POST['id_client'],
    $_POST['fname'],
    $_POST['lname'],
    $_POST['email'],
    $_POST['phone_number']
);

ClientController::updateClient($client);

header("Location: ../views/openView/openClient.php?id=" . $_POST['id_client']);
exit;
