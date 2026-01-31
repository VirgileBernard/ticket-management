<?php
require_once __DIR__ . '/../../Controllers/DeviceController.php';
require_once __DIR__ . '/../../Controllers/TypeController.php';
require_once __DIR__ . '/../../Controllers/ClientController.php';

session_start();

// Charger les types et clients pour les selects
$types = TypeController::getTypes();
$clients = ClientController::getClients();
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

<h2>Créer un nouvel appareil</h2>

<form action="../../process/createDevice.php" method="POST">

    <div class="form-group">
        <label>Modèle</label>
        <input type="text" name="model" required>
    </div>

    <div class="form-group">
        <label>Numéro de série</label>
        <input type="text" name="serial_number" required>
    </div>

    <div class="form-group">
        <label>Marque</label>
        <input type="text" name="brand" required>
    </div>

    <div class="form-group">
        <label>Type d'appareil</label>
        <select name="type_id" required>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type->getIdType() ?>">
                    <?= htmlspecialchars($type->getNom()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Client</label>
        <select name="client_id" required>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client->getId() ?>">
                    <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Date de dépôt</label>
        <input type="date" name="submission_date" required>
    </div>

    <div class="form-group">
        <label>Date de récupération</label>
        <input type="date" name="retrieve_date">
    </div>

    <button type="submit" class="btn-primary">Créer</button>
</form>

</div>

</body>
</html>
