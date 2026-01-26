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

    <div class="container">
        <h1>Materiel ID: <?= htmlspecialchars($device->getIdDevice()) ?></h1>

        <div class="device-details">
            <p><strong>Modèle :</strong> <?= htmlspecialchars($device->getModel()) ?></p>
            <p><strong>Numéro de série :</strong> <?= htmlspecialchars($device->getSerialNumber()) ?></p>
            <p><strong>Marque :</strong> <?= htmlspecialchars($device->getBrand()) ?></p>
            <p><strong>ID Type :</strong> <?= htmlspecialchars($device->getTypeId()) ?></p>
            <p><strong>ID Client :</strong> <?= htmlspecialchars($device->getClientId()) ?></p>
            <p><strong>Date de soumission :</strong> <?= htmlspecialchars($device->getSubmissionDate()) ?></p>
            <p><strong>Date de récupération :</strong> <?= htmlspecialchars($device->getRetrieveDate()) ?></p>
        </div>
    </div>


</div>
    
</body>
</html>