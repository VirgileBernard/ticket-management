<?php

require_once __DIR__ . '/../../Controllers/DeviceController.php';
session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun ticket sélectionné.");
}

$device_id = intval($_GET['id']);
$device = DeviceController::openDevice($device_id);

if(!$device) {
    die("Cet appareil n'existe pas.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiel <?php echo htmlspecialchars($device->getIdDevice()); ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main">

<?php
 include __DIR__ . '/../navbar.php';
    ?>

<div class="ticketInfo">
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
                <div class="txt-secondary">Date de dépot</div>
                <div><?= htmlspecialchars($device->getSubmissionDate()) ?></div>
            </div>
            <div class="retrieveDate">
                <div class="txt-secondary">Date de récupération</div>
                <div><?= htmlspecialchars($device->getRetrieveDate()) ?></div>
            </div>
        </div>
    </div>

    <div class="bottomTicket">
        <!-- // to do : btn submit avec modif -->
    </div>
</div>


</div>
    
</body>
</html>