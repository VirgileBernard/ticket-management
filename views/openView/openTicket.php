<?php
require_once __DIR__ . '/../../Controllers/TicketController.php';
require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';
require_once __DIR__ . '/../../Controllers/DeviceController.php';

session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun ticket sélectionné.");
}

$ticket_id = intval($_GET['id']);
$ticket = TicketController::openTicket($ticket_id);

$users = UserController::getUsers();

$clients = ClientController::getClients();

$devices = DeviceController::getDevices();

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

   

    <div class="ticketInfo" >
    <div class="topTicket">


           <div class="ticketNumber">
                <?= htmlspecialchars($ticket->getTicketNumber()) ?>
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
<div id="ticketView">
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

        <div class="bottomTicket">
            <button id="editBtn" class="btn-primary">Modifier</button>
        </div>

        

        </div>

        <form id="editForm" action="../../process/updateTicket.php" method="post" style="display:none">
            <input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket->getIdTicket()) ?>">  
            <div class="midTicket">

                <div class="leftMidTicket">
                    <div class="topColonne">
                        <p>Informations</p>
                    </div>
                    <div class="technicienInformations">
                        <label for="technician">Technicien :</label>
                        <select type="text" id="technician" name="created_by" value="<?= htmlspecialchars($ticket->creator_name) ?>" readonly>
                            <?php
                            foreach ($users as $user): ?>
                            <option value=""><?= $user->getFname();?> <?= $user->getLname(); ?>
                          </option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="clientInformations">
                        <label for="client">Client :</label>
                        <select type="text" id="client" name="client_id" value="<?= htmlspecialchars($ticket->client_name) ?>" readonly>
                                    <?php
                                    foreach ($clients as $client): ?>
                                    <option value=""><?= $client->getFname(); ?> <?= $client->getLname(); ?>
                                    </option>
                                    <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="deviceInformations">
                        <label for="device">Appareil :</label>
                        <select type="text" id="device" name="device_id" value="<?= htmlspecialchars($ticket->device_model) ?>" readonly>
                            <?php
                            foreach ($devices as $device): ?>
                            <option value="">
                                <?= $device->getModel(); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="rightMidTicket">
                    <div class="topColonne">
                        <p>Suivi de l'intervention</p>
                    </div>

                    <div class="statutTicket">
                        <label for="status">Statut :</label>
                        <select name="status_id" id="status">
                            <?php foreach ($statuses as $status): ?>
                                <?php if ($status['id'] == $ticket->status_id): ?>
                                    <?php $selected = 'selected'; ?>
                                <?php else: ?>
                                    <?php $selected = ''; ?>
                                <?php endif; ?>
                                <?= '<option value="' . $status['id'] . '" ' . $selected . '>' . $status['name'] . '</option>' ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="priorityTicket">
                        <label for="priority">Priorité :</label>
                        <select name="priority_id" id="priority">
                            <?php foreach ($priorities as $priority): ?>
                                <?php if ($priority['id'] == $ticket->priority_id): ?>
                                    <?php $selected = 'selected'; ?>
                                <?php else: ?>
                                    <?php $selected = ''; ?>
                                <?php endif; ?>
                                <?= '<option value="' . $priority['id'] . '" ' . $selected . '>' . $priority['name'] . '</option>' ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

        <div class="bottomTicket">
            <button type="submit" class="btn-primary">Enregistrer</button>  
<script>
const editBtn = document.getElementById('editBtn');
const editForm = document.getElementById('editForm');
const ticketView = document.getElementById('ticketView');
const cancelBtn = document.getElementById('cancelBtn');

editBtn.addEventListener('click', () => {
    ticketView.style.display = 'none';
    editForm.style.display = 'block';
});

cancelBtn.addEventListener('click', () => {
    editForm.style.display = 'none';
    ticketView.style.display = 'block';
});
</script>


</body>
</html>
