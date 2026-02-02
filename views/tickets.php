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
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

<div class="floatBtn">
        <button onclick="window.location='createView/createTicket.php'">
            <i class="fa-solid fa-plus"></i>
            Créer un ticket</button>
        </div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Appareil</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Technicien</th>
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
                        <td><?= htmlspecialchars($ticket->assigned_to_name) ?></td>
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