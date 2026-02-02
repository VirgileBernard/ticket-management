<?php
require_once __DIR__ . '/../../Controllers/TicketController.php';
require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';
require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/StatusController.php';
require_once __DIR__ . '/../../Controllers/PriorityController.php';
require_once __DIR__ . '/../../Controllers/InterventionController.php';

session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun ticket sélectionné.");
}

$ticket_id = intval($_GET['id']);

$ticket = TicketController::openTicket($ticket_id);
$tickets = TicketController::getTickets();

$users = UserController::getUsers();

$clients = ClientController::getClients();

$devices = DeviceController::getDevices();

$statuss = StatusController::getStatus();

$prioritys = PriorityController::getPrioritys();

$interventions = InterventionController::getInterventionsByTicket($ticket_id);

$models = array_unique(array_map(fn($d) => $d->getModel(), $devices));

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
    <div class="ticketInfo" >
    <div class="topTicket">


           <div class="ticketNumber">
             <p>   <?= htmlspecialchars($ticket->getTicketNumber()) ?></p>
            </div>
       
   

        <div class="rightTopTicket">
             <div class="ticketId">
              <p>    ID: #<?= htmlspecialchars($ticket->getIdTicket()) ?></p>
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
        <div class="userInformations">
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

        <div class="interventionSection">
            <div class="topColonne">
                <p>Détails de l'intervention</p>
            </div>
            <?php if (!empty($interventions)): ?>
                <div class="interventionHistory">
                    <?php foreach ($interventions as $intervention): ?>
                        <div class="interventionItem">
                            <p class="txt-secondary"><?= htmlspecialchars($intervention['user_name']) ?></p>
                            <p class="txt-secondary"><?= date('d/m/Y H:i', strtotime($intervention['start_at'])) ?></p>
                            <p><?= htmlspecialchars($intervention['intervention_detail']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="txt-secondary">Pas encore d'intervention</p>
            <?php endif; ?>
        </div>

        <div class="bottomTicket">
            <button id="editBtn" class="btn-primary">Modifier</button>
            <form action="../../process/deleteTicket.php" method="POST">
    <input type="hidden" name="id_ticket" value="<?= $ticket->getIdTicket() ?>">
    <button
        type="submit"
        id="dangerBtn"
        onclick="return confirm('Supprimer définitivement ce ticket ?');"
    >Supprimer
    </button>
</form>

            
        </div>

        

        </div>

        <form id="editForm" action="../../process/updateTicket.php" method="post" style="display:none" >
            <input type="hidden" name="id_ticket" value="<?= htmlspecialchars($ticket->getIdTicket()) ?>">  
            <div class="midTicket">

                <div class="leftMidTicket">
                    <div class="topColonne">
                        <p>Informations</p>
                    </div>
                    <div class="technicienInformations">
                        <label for="technician" class="txt-secondary">Technicien :</label>
                      
                        <select type="text" id="user" name="assigned_to" value="<?= htmlspecialchars($ticket->creator_name) ?>">
                            <?php
                            foreach ($users as $user): ?>
                            <option value="<?= $user->getIdUser(); ?>">
                                <?= $user->getFname();?> <?= $user->getLname(); ?>
                          </option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="clientInformations">
                        <label for="client" class="txt-secondary">Client :</label>
                        <select type="text" id="client" name="client_id" value="">
                                    <?php
                                    foreach ($clients as $client): ?>
                                    <option value="<?= $client->getId(); ?>">
                                        <?= $client->getFname(); ?> <?= $client->getLname(); ?>
                                    </option>
                                    <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="deviceInformations">
                        <label for="device" class="txt-secondary">Appareil :</label>
                        <select type="text" id="device" name="device_id">
                            <?php
                            foreach ($devices as $device): ?>
                            <option value="<?= $device->getIdDevice() ?>">
                                <?= htmlspecialchars($device->getModel()) ?>
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
                        <label for="status" class="txt-secondary">Statut :</label>
                        <select name="status_id" id="status">
                                <?php
                                foreach ($statuss as $status): ?>
                                <option value="<?= $status->getIdStatus(); ?>">
                                    <?= $status->getNom(); ?>
                                </option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="priorityTicket">
                        <label for="priority" class="txt-secondary">Priorité :</label>
                        <select name="priority_id" id="priority" >
                           <?php
                           foreach ($prioritys as $priority): ?>
                           <option value="<?= $priority->getIdPriority(); ?>">
                            <?= $priority->getNom(); ?>
                           </option>
                           <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
            </div>

            <div class="interventionEditSection">
                <div class="topColonne">
                    <p>Ajouter une intervention</p>
                </div>
                <input type="hidden" name="ticket_id" value="<?= $ticket->getIdTicket() ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['id_user'] ?>">
                <label for="intervention_detail" class="txt-secondary">Détails de l'intervention :</label>
                <textarea 
                    name="intervention_detail" 
                    id="intervention_detail"
                    placeholder="Entrez les détails de l'intervention..." 
                    rows="4"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 10px;"
                ></textarea>
            </div>
        <div class="bottomTicket">
            <button type="submit" class="btn-primary">Enregistrer</button>  
            <button type="button" onclick="window.history.back();">Annuler</button>
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
