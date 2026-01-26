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

</body>
