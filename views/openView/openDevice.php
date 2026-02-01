<?php

require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';
require_once __DIR__ . '/../../Controllers/TypeController.php';
session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun appareil sélectionné.");
}

$device_id = intval($_GET['id']);
$devices = DeviceController::getDevices();
$device = DeviceController::getDevice($device_id);

$clients = ClientController::getClients();
$types = TypeController::getTypes();

if(!$device) {
    die("Cet appareil n'existe pas.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matériel <?= htmlspecialchars($device->getIdDevice()) ?></title>
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
            <p>Informations de l'appareil</p>
        </div>
        <div class="rightTopTicket">
            <div class="deviceId">
                ID: #<?= htmlspecialchars($device->getIdDevice()) ?>
            </div>
        </div>
    </div>



    <!-- MODE LECTURE -->
    <div id="deviceView">

        <div class="midTicket">
            <div class="leftMidTicket">
                <div class="deviceType">
                    <p class="txt-secondary">Marque</p>
                    <p><?= htmlspecialchars($device->getBrandName()) ?></p>
                </div>
    
                <div class="deviceModel">
                    <p class="txt-secondary">Modèle</p>
                    <p><?= htmlspecialchars($device->getModel()) ?></p>
                </div>
                <div class="deviceBrand">
                    <p class="txt-secondary">Type d'appareil</p>
                    <p><?= htmlspecialchars($device->type_nom) ?></p>
                </div>
                    <div class="deviceSerialNumber">
                    <p class="txt-secondary">Numéro de série</p>
                    <p><?= htmlspecialchars($device->getSerialNumber()) ?></p>
                </div>
            </div>

            <div class="rightMidTicket">
                <div class="deviceClientId">
                    <p class="txt-secondary">Client</p>
                    <p><?= htmlspecialchars($device->client_name) ?></p>
                </div>
                <div class="submissionDate">
                    <p class="txt-secondary">Date de dépôt</p>
                    <p><?= htmlspecialchars($device->getSubmissionDate()) ?></p>
                </div>
                <div class="retrieveDate">
                    <p class="txt-secondary">Date de récupération</p>
                    <p><?= htmlspecialchars($device->getRetrieveDate()) ?></p>
                </div>
            </div>
        </div>

        <div class="bottomTicket">
            <button id="editBtn" class="btn-primary">Modifier</button>
             <form action="../../process/deleteDevice.php" method="POST">
    <input type="hidden" name="id_device" value="<?= $device->getIdDevice() ?>">
    <button
        type="submit"
        id="dangerBtn"
        onclick="return confirm('Supprimer définitivement ce matériel ?');"
    >Supprimer
    </button>
</form>
        </div>

    </div>


<form id="editForm" action="../../process/updateDevice.php" method="POST" style="display:none">

    <input type="hidden" name="id_device" value="<?= $device->getIdDevice() ?>">

    <div class="midTicket">
        <div class="leftMidTicket">

            <div class="deviceBrand">
                <p class="txt-secondary">Marque</p>
                <select name="brand" id="brand_id">
                    <?php foreach ($devices as $d): ?>
                        <option value="<?= $d->getBrandName(); ?>"
                            <?= $d->getBrandName() === $device->getBrandName() ? 'selected' : '' ?>>
                            <?= $d->getBrandName(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="deviceModele">
                <p class="txt-secondary">Modèle</p>
                <select name="model" id="model">
                    <?php foreach ($devices as $d): ?>
                        <option value="<?= $d->getModel(); ?>"
                            <?= $d->getModel() === $device->getModel() ? 'selected' : '' ?>>
                            <?= $d->getModel(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="deviceType">
                <p class="txt-secondary">Type d'appareil</p>
                <select name="type_id" id="type">
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type->getIdType(); ?>">
                        <?= $type->getNom(); ?>  
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>

                <div class="deviceSerialNumber">
                <p class="txt-secondary">Numéro de série</p>
                <input type="text" name="serial_number" value="<?= htmlspecialchars($device->getSerialNumber()) ?>">
            </div>

        </div>

        <div class="rightMidTicket">

            <div class="deviceClientId">
                <p class="txt-secondary">Client</p>
                <select id="client" name="client_id">
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client->getId(); ?>"
                            <?= $client->getId() === $device->getClientId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="submissionDate">
                <p class="txt-secondary">Date de dépôt</p>
                <input type="date" name="submission_date" id="date" value="<?= htmlspecialchars($device->getSubmissionDate()) ?>">
            </div>

            <div class="retrieveDate">
                <p class="txt-secondary">Date de récupération</p>
                <input type="date" name="retrieve_date" id="date" value="<?= htmlspecialchars($device->getRetrieveDate()) ?>">
            </div>

        </div>
    </div>

    <div class="bottomTicket">
        <button type="submit" class="btn-primary">Enregistrer</button>
        <button type="button" id="cancelBtn" class="btn-secondary">Annuler</button>
    </div>

</form>

</div>

<script>
const editBtn = document.getElementById('editBtn');
const editForm = document.getElementById('editForm');
const deviceView = document.getElementById('deviceView');
const cancelBtn = document.getElementById('cancelBtn');

editBtn.addEventListener('click', () => {
    deviceView.style.display = 'none';
    editForm.style.display = 'block';
});

cancelBtn.addEventListener('click', () => {
    editForm.style.display = 'none';
    deviceView.style.display = 'block';
});
</script>

</body>
</html>
