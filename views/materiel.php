<?php

session_start();

 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
 }

 require_once ("../Controllers/DeviceController.php");
 require_once ("../models/Device.php");

    $devices = DeviceController::getDevices();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
    <title>Gestion du matériel</title>
</head>
<body>
    
    <div class="main">
    <?php include("navbar.php"); ?>
    <div class="container">
    <h1>Liste du matériel</h1>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de série</th>
                <th>Type</th>
                <th>Date de soumission</th>
                <th>Date de récupération</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devices as $device): ?>
            <tr>
                <td><?= $device->getIdDevice() ?></td>
                <td><?= $device->getBrand() ?></td>
                <td><?= $device->getModel() ?></td>
                <td><?= $device->getSerialNumber() ?></td>
                <td><?= $device->getTypeId() ?></td>
                <td><?= $device->getSubmissionDate() ?></td>
                <td><?= $device->getRetrieveDate() ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>

    <?php include("footer.php"); ?>
    </body>
</html>