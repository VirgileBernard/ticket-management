<?php

session_start();

 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
 }

 require_once ("../Controllers/DeviceController.php");
 require_once ("../Controllers/TypeController.php");
 require_once ("../models/Device.php");
 require_once ("../models/Type.php");


    $devices = DeviceController::getDevices();
    $types= TypeController::getTypes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gestion du matériel</title>
</head>
<body>
    
    <div class="main">
    <?php include("navbar.php"); ?>
    <div class="container">
        <div class="topContainer">
    <div class="infoView">
        <p class="strong">Matériel</p>
        <p>Voici l'ensemble du matériel, <?= htmlspecialchars($_SESSION['user_fname']) ?> <?= htmlspecialchars($_SESSION['user_lname']) ?></p>
    </div>
    </div>
    <div class="floatBtn">
        
    <button onclick="window.location='createView/createDevice.php'">
        <i class="fa-solid fa-plus"></i>
        Créer du matériel</button>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>Appareil</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de série</th>
                <!-- <th>Date de soumission</th>
                <th>Date de récupération</th> -->
            </tr>
        </thead>
    
        <tbody>
            <?php foreach ($devices as $device): ?>


         
            <tr onclick="window.location='openView/openDevice.php?id=<?= $device->getIdDevice() ?>'">
             <td><?= $device->type_nom ?></td>
             <td><?= $device->getBrandName() ?></td>
                <td><?= $device->getModel() ?></td>
                <td><?= $device->getSerialNumber() ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>


        
<?php if (isset($_SESSION['flash_message_success'])): ?>
    <div class="flash-message success">
        <?= $_SESSION['flash_message_success'] ?>
    </div>
    <?php unset($_SESSION['flash_message_success']); ?>
<?php endif; ?>


        <?php if (isset($_SESSION['flash-message edit'])): ?>
    <div id="flash-message edit" class="flash-message edit">
        <?= $_SESSION['flash-message edit'] ?>
    </div>
    <?php unset($_SESSION['flash-message edit']); ?>
<?php endif; ?>

 <?php if (isset($_SESSION['flash-message delete'])): ?>
    <div id="flash-message delete" class="flash-message delete">
        <?= $_SESSION['flash-message delete'] ?>
    </div>
    <?php unset($_SESSION['flash-message delete']); ?>
<?php endif; ?>



    <?php include("footer.php"); ?>

    </body>
</html>