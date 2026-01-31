<?php
require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/TypeController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';

session_start();

// Charger les types, clients et devices pour les selects
$types = TypeController::getTypes();
$clients = ClientController::getClients();
$devices = DeviceController::getDevices(); // Pour marques et modèles existants
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un appareil</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main">

<?php include __DIR__ . '/../navbar.php'; ?>

<div class="ticketInfo">

    <!-- TOP -->
    <div class="topTicket">
        <div class="leftTopTicket">
            <p>Créer un nouvel appareil</p>
        </div>
    </div>

    <!-- FORMULAIRE -->
    <form action="../../process/createDevice.php" method="POST" id="editForm">

        <div class="midTicket">

            <!-- COLONNE GAUCHE -->
            <div class="leftMidTicket">

                <div class="deviceBrand">
                    <p class="txt-secondary">Marque</p>
                    <select name="brand" required>
                        <?php foreach ($devices as $d): ?>
                            <option value="<?= htmlspecialchars($d->getBrandName()) ?>">
                                <?= htmlspecialchars($d->getBrandName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="deviceModel">
                    <p class="txt-secondary">Modèle</p>
                    <select name="model" required>
                        <?php foreach ($devices as $d): ?>
                            <option value="<?= htmlspecialchars($d->getModel()) ?>">
                                <?= htmlspecialchars($d->getModel()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="deviceType">
                    <p class="txt-secondary">Type d'appareil</p>
                    <select name="type_id" required>
                        <?php foreach ($types as $type): ?>
                            <option value="<?= $type->getIdType() ?>">
                                <?= htmlspecialchars($type->getNom()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="deviceSerialNumber">
                    <p class="txt-secondary">Numéro de série</p>
                    <input type="text" name="serial_number" required>
                </div>

            </div>

            <!-- COLONNE DROITE -->
            <div class="rightMidTicket">

                <div class="deviceClientId">
                    <p class="txt-secondary">Client</p>
                    <select name="client_id" required>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client->getId() ?>">
                                <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="submissionDate">
                    <p class="txt-secondary">Date de dépôt</p>
                    <input type="date" name="submission_date" required>
                </div>

                <div class="retrieveDate">
                    <p class="txt-secondary">Date de récupération</p>
                    <input type="date" name="retrieve_date">
                </div>

            </div>
        </div>

        <!-- BOUTONS -->
        <div class="bottomTicket">
            <button type="submit" class="btn-primary">Créer</button>
            <button type="button" class="btn-secondary" onclick="window.location='../devices.php'">Annuler</button>
        </div>

    </form>

</div>

</div>

</body>
</html>
