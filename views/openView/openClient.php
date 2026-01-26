<?php

require_once __DIR__ . '/../../Controllers/ClientController.php';

session_start();



// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun client sélectionné.");
}

$client_id = intval($_GET['id']);
$client = ClientController::openClient($client_id);

// Vérifier que le client existe
if (!$client) {
    die("Ce client n'existe pas.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Client <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()) ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="main">
<?php

 include __DIR__ . '/../navbar.php';
    ?>

    <div class="container">

        <h1>
            Client : <?= htmlspecialchars($client->getFname() . ' ' . $client->getLname()) ?>
        </h1>

        <div class="ticket-details">

            <p><strong>Prénom :</strong>
                <?= htmlspecialchars($client->getFname()) ?>
            </p>

            <p><strong>Nom :</strong>
                <?= htmlspecialchars($client->getLname()) ?>
            </p>

            <p><strong>Email :</strong>
                <?= htmlspecialchars($client->getEmail()) ?>
            </p>

            <p><strong>Numéro de téléphone :</strong>
                <?= htmlspecialchars($client->getPhone()) ?>
            </p>

        </div>

    </div>
</div>

<a href="index.php">⬅ Retour à la liste</a>

</body>
</html>
