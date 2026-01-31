 <?php
session_start();


 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
}

require_once("../Controllers/ClientController.php");
require_once("../models/Client.php");

$clients = ClientController::getClients();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="style.css">
    <title>Gestion des clients</title>
</head>


<body>
    <div class="main">
    <?php
     include("navbar.php");
    ?>
    <div class="container">
    <div class="topContainer">
    <div class="infoView">
        <p class="strong">Clients</p>
        <p>Voici l'ensemble de vos clients, <?= htmlspecialchars($_SESSION['user_fname']) ?> <?= htmlspecialchars($_SESSION['user_lname']) ?></p>
    </div>
</div>

<div class="floatBtn">
        
    <button onclick="window.location='createView/createClient.php'">
        <i class="fa-solid fa-plus"></i>
        Créer un client</button>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr onclick="window.location='openView/openClient.php?id=<?= $client->getId() ?>'">
                <td><?= $client->getId() ?></td>
                <td><?= $client->getFname() ?></td>
                <td><?= $client->getLname() ?></td>
                <td><?= $client->getEmail() ?></td>
                <td><?= $client->getPhone() ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>


    <?php include("footer.php"); ?>
        
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
</body>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const flash = document.getElementById("edit_succes");
    if (flash) {
        setTimeout(() => {
            flash.remove();
        }, 4000); // même durée que l’animation
    }
});
</script>
</html>
