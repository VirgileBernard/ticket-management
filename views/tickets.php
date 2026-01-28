 <?php

 session_start();


// var_dump($_SESSION);
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
}

require_once("../Controllers/TicketController.php");
require_once("../models/Ticket.php");


$tickets = TicketController::getTickets();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestion des Tickets</title>
</head>
<body>
<div class="main">
     <?php include("navbar.php"); ?>
<div class="container">
     <div class="topContainer">
    <div class="infoView">
        <p class="strong">Tickets</p>
        <p>Voici l'ensemble de vos tickets, <?= htmlspecialchars($_SESSION['user_fname']) ?> <?= htmlspecialchars($_SESSION['user_lname']) ?></p>
    </div>
</div>
        
  <table class="user-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Appareil</th>
            <th>Statut</th>
            <th>Priorité</th>
            <th>Créé par</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($tickets as $ticket): ?>
           <tr onclick="window.location='openView/openTicket.php?id=<?= $ticket->getIdTicket() ?>'">
                <td><?= htmlspecialchars($ticket->getTicketNumber()) ?></td>
                <td><?= htmlspecialchars($ticket->client_name) ?></td>
                <td><?= htmlspecialchars($ticket->device_model) ?></td>
                <td><?= htmlspecialchars($ticket->status_name) ?></td>
                <td><?= htmlspecialchars($ticket->priority_name) ?></td>
                <td><?= htmlspecialchars($ticket->creator_name) ?></td>
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