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

    <div class="container">

        <h1>
            Ticket <?= htmlspecialchars($ticket->getTicketNumber()) ?>
        </h1>

        <!-- Formulaire d’édition inline -->
        <form id="editForm" action="../process/updateTicket.php" method="POST">
            <input type="hidden" name="id_ticket" value="<?= $ticket->getIdTicket() ?>">

            <p>
                <strong>Client :</strong>
                <!-- lecture seule pour l’instant -->
                <span><?= htmlspecialchars($ticket->client_name) ?></span>
            </p>

            <p>
                <strong>Appareil :</strong>
                <!-- lecture seule pour l’instant -->
                <span><?= htmlspecialchars($ticket->device_model) ?></span>
            </p>

    <p>
    <strong>Statut :</strong>

    <!-- Mode lecture -->
    <span 
        class="field-view"
        data-field="status_id"
    >
        <?= htmlspecialchars($ticket->status_name) ?>
    </span>

    <!-- Mode édition -->
    <select 
        class="field-edit"
        name="status_id"
        data-field="status_id"
        style="display:none;"
    >
        <option value="1" <?= $ticket->getStatusId() == 1 ? 'selected' : '' ?>>Ouvert</option>
        <option value="2" <?= $ticket->getStatusId() == 2 ? 'selected' : '' ?>>En cours</option>
        <option value="3" <?= $ticket->getStatusId() == 3 ? 'selected' : '' ?>>Clôturé</option>
    </select>
</p>


            <p>
                <strong>Priorité :</strong>
                <span
                    class="field-view"
                    data-field="priority_id"
                >
                    <?= htmlspecialchars($ticket->priority_name) ?>
                </span>

                <select
                    class="field-edit"
                    name="priority_id"
                    data-field="priority_id"
                    style="display:none;"
                >
                    <option value="1" <?= $ticket->getPriorityId() == 1 ? 'selected' : '' ?>>Basse</option>
                    <option value="2" <?= $ticket->getPriorityId() == 2 ? 'selected' : '' ?>>Moyenne</option>
                    <option value="3" <?= $ticket->getPriorityId() == 3 ? 'selected' : '' ?>>Haute</option>
                </select>
            </p>

            <p><strong>Créé par :</strong> <?= htmlspecialchars($ticket->creator_name) ?></p>

            <button type="submit">Enregistrer les modifications</button>
            <button type="button" onclick="window.location.reload()">Annuler</button>
        </form>

    </div>
</div>

<a href="index.php">⬅ Retour à la liste des tickets</a>

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
