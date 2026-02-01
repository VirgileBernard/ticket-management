<?php
require_once __DIR__ . '/../../Controllers/ClientController.php';



session_start();

$clients = ClientController::getClients();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>



<div class="main">

<?php include __DIR__ . '/../navbar.php'; ?>
    <div class="container">
<div class="ticketInfo">

    <!-- TOP -->
    <div class="topTicket">
        <div class="leftTopTicket">
            <p>Créer un nouveau client</p>
        </div>
    </div>


    <form action="../../process/createClient.php" method="POST" id="editForm">

    <div class="midTicket">
        <div class="leftMidTicket">
            <div class="clientLName">
                   <p class="txt-secondary">Nom du client</p>
                   <input type="text" name="lname" placeholder="Nom de famille">
            </div>
                  <div class="clientMail">
                   <p class="txt-secondary">Nom du client</p>
                   <input type="text" name="email" placeholder="email@bernitickets.be">
            </div>
        </div>

          <div class="rightMidTicket">
            <div class="clientFname">
                   <p class="txt-secondary">Nom du client</p>
                   <input type="text" name="fname" placeholder="Prénom">
            </div>
                  <div class="clientPhone">
                   <p class="txt-secondary">Numéro de téléphone</p>
                   <input type="text" name="phone" placeholder="0470102030">
            </div>
        </div>


    </div>

     <div class="bottomTicket">
            <button type="submit" class="btn-primary">Créer</button>
                   <button type="button" class="btn-secondary" onclick="window.location='../clients.php'">Annuler</button>
        </div>

    </form>
    
</body>
</html>