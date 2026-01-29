<?php

require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';
session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun appareil sélectionné.");
}

$device_id = intval($_GET['id']);
$devices = DeviceController::getDevices();
$device = DeviceController::getDevice($device_id);

$clients = ClientController::getClients();

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
                    <p><?= htmlspecialchars($device->getType()) ?></p>
                </div>
    
                <div class="deviceModel">
                    <p class="txt-secondary">Modèle</p>
                    <p><?= htmlspecialchars($device->getModel()) ?></p>
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
        </div>

    </div>


    <!-- MODE ÉDITION (caché au départ) -->
    <form id="editForm" action="../../process/updateDevice.php" method="POST" style="display:none;">

        <input type="hidden" name="id_device" value="<?= $device->getIdDevice() ?>">

        <div class="midTicket">
            <div class="leftMidTicket">

                <div class="deviceType">
                    <p class="txt-secondary">Marque</p>
                    <select name="brand" id="brand_id" value="<?= htmlspecialchars($device->getBrand()) ?>">
                        <?php foreach ($devices as $device): ?>
                            <option value="<?= $device->getBrand(); ?>">
                                <?= $device->getBrand(); ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
<?php var_dump($device); ?>
                <div class="deviceBrand">
                    <p class="txt-secondary">Modèle</p>
                    <select type="text" name="model" id="model" value="<?= htmlspecialchars($device->getModel()) ?>">
                        <?php
                        foreach ($devices as $device): ?>
                        <option value="<?= $device->getModel(); ?>">
                            <?= $device->getModel(); ?>
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
                  
        <select type="text" id="client" name="client_id" value="<?= htmlspecialchars($clients->fname) ?>">
                                    <?php
                                    foreach ($clients as $client): ?>
                                    <option value="<?= $client->getId(); ?>">
                                    </option>
                                    <?php endforeach; ?>
                        </select>
                </div>

                <div class="submissionDate">
                    <p class="txt-secondary">Date de dépôt</p>
                    <input type="date" name="submission_date" value="<?= htmlspecialchars($device->getSubmissionDate()) ?>">
                </div>

                <div class="retrieveDate">
                    <p class="txt-secondary">Date de récupération</p>
                    <input type="date" name="retrieve_date" value="<?= htmlspecialchars($device->getRetrieveDate()) ?>">
                </div>

            </div>
        </div>

        <div class="bottomTicket">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <button type="button" id="cancelBtn" class="btn-secondary">Annuler</button>
        </div>

    </form>

</div>

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
