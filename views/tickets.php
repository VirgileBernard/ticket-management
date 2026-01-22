 <?php include("navbar.php");


// var_dump($_SESSION);
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
}

require_once("../Controllers/TicketController.php");
require_once("../models/Ticket.php");
// $users = UserController::getUsers();
$tickets = TicketController::getTickets();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestion des Tickets</title>
</head>
<body>

<div class="container">
      <h1>Liste des tickets</h1>
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
            <tr>
                <td><?= htmlspecialchars($ticket->getTicketNumber()) ?></td>
                <td><?= htmlspecialchars($ticket->getClientId()) ?></td>
                <td><?= htmlspecialchars($ticket->getDeviceId()) ?></td>
                <td><?= htmlspecialchars($ticket->getStatusId()) ?></td>
                <td><?= htmlspecialchars($ticket->getPriorityId()) ?></td>
                <td><?= htmlspecialchars($ticket->getCreatedBy()) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php include("footer.php"); ?>

</body>