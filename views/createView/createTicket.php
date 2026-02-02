<?php
require_once __DIR__ . '/../../Controllers/TicketController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';
require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/TypeController.php';
require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/StatusController.php';
require_once __DIR__ . '/../../Controllers/PriorityController.php';


session_start();

// Charger les données nécessaires
$clients = ClientController::getClients();
$devices = DeviceController::getDevices();
$types = TypeController::getTypes();
$users = UserController::getUsers(); 
$statuss = StatusController::getStatus();
$prioritys = PriorityController::getPrioritys();

$models = array_unique(array_map(fn($d) => $d->getModel(), $devices));
$brands = array_unique(array_map(fn($d) => $d->getBrandName(), $devices));

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un ticket</title>
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
            <p>Créer un nouveau ticket</p>
        </div>
    </div>

    <!-- FORMULAIRE -->
    <form action="../../process/createTicket.php" method="POST" id="editForm">

        <div class="midTicket">

            <!-- COLONNE GAUCHE -->
            <div class="leftMidTicket">



                <div class="ticketClient">
                    <p class="txt-secondary">Client</p>
                    <select name="client_id" required>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client->getId() ?>">
                                <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="ticketBrand">
                    <p class="txt-secondary">Marque</p>
   <select name="brand" required>
                     <?php
                            foreach ($brands as $brand): ?>
                            <option value="<?= htmlspecialchars($brand) ?>"> <?= htmlspecialchars($brand) ?> </option> <?php endforeach; ?> </select>
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
                     <?php
                            foreach ($devices as $device): ?>
                            <option value="<?= $device->getIdDevice() ?>"> <?= htmlspecialchars($device->getModel()) ?> </option> <?php endforeach; ?> </select>
                        </select>
                </div>

            </div>

            <!-- COLONNE DROITE -->
            <div class="rightMidTicket">

              <div class="ticketTechnician">
                    <p class="txt-secondary">Technicien assigné</p>
                    <select name="assigned_to" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user->getIdUser() ?>">
                                <?= htmlspecialchars($user->getFname() . ' ' . $user->getLname()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="ticketPriority">
                    <p class="txt-secondary">Priorité</p>
                    <select name="priority_id" required>
                        <?php foreach ($prioritys as $prority): ?>
                            <option value="<?= $prority->getIdPriority() ?>">
                                <?= htmlspecialchars($prority->getNom()) ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>

              

                <div class="ticketStatus">
                    <p class="txt-secondary">Statut</p>
                    <select name="status_id" id="status">
                    <?php
                                foreach ($statuss as $status): ?>
                                <option value="<?= $status->getIdStatus(); ?>">
                                    <?= $status->getNom(); ?>
                                </option>
                                <?php endforeach; ?>
                    </select>
                </div>

                <div class="ticketDate">
                    <p class="txt-secondary">Date de création</p>
                    <input type="date" name="creation_date" value="<?= date('Y-m-d') ?>" required>
                </div>

            </div>
        </div>

        <!-- <div class="test">
                 <div class="ticketDescription">
                    <p class="txt-secondary">Description</p>
                    <textarea name="description" rows="5" required></textarea>
                </div>
        </div> -->

        <!-- BOUTONS -->
        <div class="bottomTicket">
            <button type="submit" class="btn-primary">Créer</button>
            <button type="button" class="btn-secondary" onclick="window.location='../tickets.php'">Annuler</button>
        </div>

    </form>

</div>
</div>


</div>
</body>
</html>
