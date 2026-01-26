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

    <?php include __DIR__ . '/../navbar.php'; ?>

   

    <div class="ticketInfo">
        <!-- <a href="index.php">⬅ Retour à la liste des tickets</a> -->
<!-- <?php var_dump($ticket); ?> -->

    <div class="topTicket">

     <div class="leftTopTicket">

           <div class="ticketNumber">
    
        <?= htmlspecialchars($ticket->getTicketNumber()) ?>
        </div>
        <div class="ticketStatus <?= strtolower($ticket->status_name) ?>">
            <?= htmlspecialchars($ticket->status_name) ?>
        </div>
     </div>

     <div class="rightTopTicket">

        <div class="ticketId">
            ID: #<?= htmlspecialchars($ticket->getIdTicket()) ?>
        </div>
        <div class="creationDate">
            <p><?= date('d/m/Y', strtotime($ticket->intervention_start)) ?></p>
        </div>
    </div>

    </div>

    <div class="midTicket">

    <div class="leftMidTicket">
        <div class="topColonne">
            <p>Informations</p>
        </div>
        <div class="technicienInformations">
            <p class="txt-secondary">Technicien</p>  <!-- TODO : afficher dynamiquement le role du technicien assigné -->
            <p><?= htmlspecialchars($ticket->creator_name) ?></p>
        </div>
        <div class="clientInformations">
            <p class="txt-secondary">Client</p>
            <p><?= htmlspecialchars($ticket->client_name) ?></p>
        </div>
        <div class="deviceInformations">
           <p class="txt-secondary">Appareil</p>
            <p><?= htmlspecialchars($ticket->device_model) ?></p>
        </div>
      
        <div class="descriptionTicket">
            <p>Description</p>
            <!-- TODO : ajouter la description du ticket -->
        </div>
    </div>

    <div class="rightMidTicket">
        <div class="topColonne">
            <p>Suivi de l'intervention</p>
        </div>
        <div class="statutTicket">
            <p class="txt-secondary">Statut</p>
            <p><?= htmlspecialchars($ticket->status_name) ?></p>
        </div>
          <div class="priorityTicket">
            <p>Priorité</p>
            <p><?= htmlspecialchars($ticket->priority_name) ?></p>
        </div>

    </div>
    </div>




<script>
document.querySelectorAll('.field-view').forEach(span => {
    span.addEventListener('click', () => {
        const field = span.dataset.field;
        const editInput = document.querySelector('.field-edit[data-field="' + field + '"]');

        span.style.display = 'none';
        editInput.style.display = 'inline-block';
        editInput.focus();
    });
});

document.querySelectorAll('.field-edit').forEach(input => {
    input.addEventListener('blur', () => {
        const field = input.dataset.field;
        const viewSpan = document.querySelector('.field-view[data-field="' + field + '"]');

        if (input.tagName === 'SELECT') {
            const selectedText = input.options[input.selectedIndex].textContent;
            viewSpan.textContent = selectedText;
        } else {
            viewSpan.textContent = input.value;
        }

        input.style.display = 'none';
        viewSpan.style.display = 'inline';
    });
});
</script>

</body>
</html>
