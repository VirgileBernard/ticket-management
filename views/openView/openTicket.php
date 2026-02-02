<?php
require_once __DIR__ . '/../../Controllers/TicketController.php';
require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';
require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/StatusController.php';
require_once __DIR__ . '/../../Controllers/PriorityController.php';
require_once __DIR__ . '/../../Controllers/TypeController.php';
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

$types = TypeController::getTypes();

$interventions = InterventionController::getInterventionsByTicket($ticket_id);

// Créer arrays sans doublons pour Brand et Type
$brands = array_unique(array_map(fn($d) => $d->getBrandName(), $devices));
$models = array_unique(array_map(fn($d) => $d->getModel(), $devices));
$materiels = [];
foreach ($devices as $device) {
    $model = $device->getModel();
    if (!isset($materiels[$model])) {
        // on garde le premier id_device rencontré pour ce modèle
        $materiels[$model] = $device->getIdDevice();
    }
}




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
<?php
// Obtenir le device actuel pour afficher ses infos
$current_device = null;
foreach ($devices as $device) {
    if ($device->getIdDevice() == $ticket->getDeviceId()) {
        $current_device = $device;
        break;
    }
}
// Obtenir le type d'appareil
$current_type = null;
if ($current_device) {
    foreach ($types as $type) {
        if ($type->getIdType() == $current_device->getType()) {
            $current_type = $type;
            break;
        }
    }
}
?>
<div id="ticketView">
    <div class="midTicket">

    <div class="leftMidTicket">
        <div class="topColonne">
            <p>Informations</p>
        </div>

                <div class="clientInformations">
            <p class="txt-secondary">Client</p>
            <p><?= htmlspecialchars($ticket->client_name) ?></p>
        </div>
        

        <div class="deviceBrand">
            <p class="txt-secondary">Marque</p>
            <p><?= $current_device ? htmlspecialchars($current_device->getBrandName()) : 'N/A' ?></p>
        </div>

        <div class="deviceType">
            <p class="txt-secondary">Type d'appareil</p>
            <p><?= $current_type ? htmlspecialchars($current_type->getNom()) : 'N/A' ?></p>
        </div>

        <div class="deviceInformations">
           <p class="txt-secondary">Matériel concerné</p>
            <p><?= htmlspecialchars($ticket->device_model) ?></p>
        </div>
    
    </div>

    <div class="rightMidTicket">
        <div class="topColonne">
            <p>Suivi de l'intervention</p>
        </div>

                <div class="userInformations">
            <p class="txt-secondary">Technicien</p>  <!-- TODO : afficher dynamiquement le role du technicien assigné -->
            <p><?= htmlspecialchars($ticket->creator_name) ?></p>
        </div>

             <div class="priorityTicket">
            <p>Priorité</p>
            <p><?= htmlspecialchars($ticket->priority_name) ?></p>
        </div>
        <div class="statutTicket">
            <p class="txt-secondary">Statut</p>
            <p><?= htmlspecialchars($ticket->status_name) ?></p>
        </div>

                        <div class="ticketDate">
                    <p class="txt-secondary">Date de création</p>
                     <p><?= date('d/m/Y', strtotime($ticket->intervention_start)) ?></p>
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

                    <div class="ticketClient">
                        <p class="txt-secondary">Client</p>
                   <select name="client_id" required>
    <?php foreach ($clients as $client): ?>
        <option 
            value="<?= $client->getId(); ?>"
            <?= $client->getId() == $ticket->getClientId() ? 'selected' : '' ?>
        >
            <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()); ?>
        </option>
    <?php endforeach; ?>
</select>

                    </div>

                    <div class="ticketBrand">
                        <p class="txt-secondary">Marque</p>
                        <select name="brand" required>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= htmlspecialchars($brand) ?>"> <?= htmlspecialchars($brand) ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ticketType">
                        <p class="txt-secondary">Type d'appareil</p>
                        <select name="type_id" required>
                            <?php foreach ($types as $type): ?>
                                <option value="<?= $type->getIdType() ?>">
                                    <?= htmlspecialchars($type->getNom()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ticketDevice">
                        <p class="txt-secondary">Matériel concerné</p>
                      <select name="device_id" required>
    <?php foreach ($materiels as $model => $id_device): ?>
     <option 
    value="<?= $id_device ?>"
    <?= $id_device == $ticket->getDeviceId() ? 'selected' : '' ?>
>
    <?= htmlspecialchars($model) ?>
</option>

    <?php endforeach; ?>
</select>
      
                    </div>

                </div>

                <div class="rightMidTicket">
                    <div class="topColonne">
                        <p>Suivi de l'intervention</p>
                    </div>

                    <div class="ticketTechnician">
                        <p class="txt-secondary">Technicien assigné</p>
                        <select name="assigned_to" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user->getIdUser(); ?>">
                                    <?= htmlspecialchars($user->getFname() . ' ' . $user->getLname()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ticketPriority">
                        <p class="txt-secondary">Priorité</p>
                        <select name="priority_id" required>
                            <?php foreach ($prioritys as $priority): ?>
                                <option value="<?= $priority->getIdPriority(); ?>">
                                    <?= htmlspecialchars($priority->getNom()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ticketStatus">
                        <p class="txt-secondary">Statut</p>
                        <select name="status_id" required>
                            <?php foreach ($statuss as $status): ?>
                                <option value="<?= $status->getIdStatus(); ?>">
                                    <?= htmlspecialchars($status->getNom()); ?>
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
                ></textarea>
            </div>

            <div class="bottomTicket">
                <button type="submit" class="btn-primary">Enregistrer</button>  
                <button type="button" class="btn-secondary" onclick="cancelEdit();">Annuler</button>
            </div>
        </form>

<script>
const editBtn = document.getElementById('editBtn');
const editForm = document.getElementById('editForm');
const ticketView = document.getElementById('ticketView');

function editTicket() {
    ticketView.style.display = 'none';
    editForm.style.display = 'block';
}

function cancelEdit() {
    editForm.style.display = 'none';
    ticketView.style.display = 'block';
}

editBtn.addEventListener('click', editTicket);
</script>

</body>
</html>
