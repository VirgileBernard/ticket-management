<?php
require_once __DIR__ . '/../../Controllers/TicketController.php';
session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun ticket sélectionné.");
}

$ticket_id = intval($_GET['id']);
$ticket = TicketController::openTicket($ticket_id);

// Vérifier que le ticket existe
if (!$ticket) {
    die("Ce ticket n'existe pas.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket <?= htmlspecialchars($ticket->getTicketNumber()) ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="main">

    <?php
 include __DIR__ . '/../navbar.php';
 ?>
 <div class="container">
<h1>Ticket <?= htmlspecialchars($ticket->getTicketNumber()) ?></h1>

<div class="ticket-details">

    <p><strong>Client :</strong> 
        <?= htmlspecialchars($ticket->client_name) ?>
    </p>

    <p><strong>Appareil :</strong> 
        <?= htmlspecialchars($ticket->device_model) ?>
    </p>

    <p><strong>Statut :</strong> 
        <?= htmlspecialchars($ticket->status_name) ?>
    </p>

    <p><strong>Priorité :</strong> 
        <?= htmlspecialchars($ticket->priority_name) ?>
    </p>

    <p><strong>Créé par :</strong> 
        <?= htmlspecialchars($ticket->creator_name) ?>
    </p>

</div>
</div>
</div>

<a href="index.php">⬅ Retour à la liste des tickets</a>

</body>
</html>
