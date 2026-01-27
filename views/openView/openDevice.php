<?php

require_once __DIR__ . '/../../Controllers/DeviceController.php';
session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun appareil sélectionné.");
}

$device_id = intval($_GET['id']);
$device = DeviceController::openDevice($device_id);

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
                    <p class="txt-secondary">Type d'appareil</p>
                    <p><?= htmlspecialchars($device->getTypeId()) ?></p>
                </div>
                <div class="deviceBrand">
                    <p class="txt-secondary">Marque</p>
                    <p><?= htmlspecialchars($device->getBrand()) ?></p>
                </div>
                <div class="deviceModel">
                    <p class="txt-secondary">Modèle</p>
                    <p><?= htmlspecialchars($device->getModel()) ?></p>
                </div>
            </div>

            <div class="rightMidTicket">
                <div class="deviceSerialNumber">
                    <p class="txt-secondary">Numéro de série</p>
                    <p><?= htmlspecialchars($device->getSerialNumber()) ?></p>
                </div>
                <div class="deviceClientId">
                    <p class="txt-secondary">ID Client</p>
                    <p><?= htmlspecialchars($device->getClientId()) ?></p>
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
                    <p class="txt-secondary">Type d'appareil</p>
                    <input type="text" name="type_id" value="<?= htmlspecialchars($device->getTypeId()) ?>">
                </div>

                <div class="deviceBrand">
                    <p class="txt-secondary">Marque</p>
                    <input type="text" name="brand" value="<?= htmlspecialchars($device->getBrand()) ?>">
                </div>

                <div class="deviceModel">
                    <p class="txt-secondary">Modèle</p>
                    <input type="text" name="model" value="<?= htmlspecialchars($device->getModel()) ?>">
                </div>

            </div>

            <div class="rightMidTicket">

                <div class="deviceSerialNumber">
                    <p class="txt-secondary">Numéro de série</p>
                    <input type="text" name="serial_number" value="<?= htmlspecialchars($device->getSerialNumber()) ?>">
                </div>

                <div class="deviceClientId">
                    <p class="txt-secondary">ID Client</p>
                    <input type="number" name="client_id" value="<?= htmlspecialchars($device->getClientId()) ?>">
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
