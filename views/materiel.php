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
        <div class="topContainer">
    <div class="infoView">
        <p class="strong">Matériel</p>
        <p>Voici l'ensemble de votre matériel, <?= htmlspecialchars($_SESSION['user_fname']) ?> <?= htmlspecialchars($_SESSION['user_lname']) ?></p>
    </div>
</div>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de série</th>
                <th>Type</th>
                <!-- <th>Date de soumission</th>
                <th>Date de récupération</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devices as $device): ?>
            <tr onclick="window.location='openView/openDevice.php?id=<?= $device->getIdDevice() ?>'">
                <td><?= $device->getIdDevice() ?></td>
                <td><?= $device->getBrand() ?></td>
                <td><?= $device->getModel() ?></td>
                <td><?= $device->getSerialNumber() ?></td>
                <td><?= $device->getTypeId() ?></td>
                <!-- <td><?= $device->getSubmissionDate() ?></td>
                <td><?= $device->getRetrieveDate() ?></td> -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>

    <?php include("footer.php"); ?>
        <?php if (isset($_SESSION['flash_success'])): ?>
    <div id="flashMessage" class="flash-success">
        <?= $_SESSION['flash_success'] ?>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>
    </body>
</html>