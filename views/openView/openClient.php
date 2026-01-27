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

    <div class="ticketInfo">
    
      <div class="topTicket">
         <div class="leftTopTicket">
            <p>Informations du client</p>
         </div>
         <div class="rightTopTicket">
            <div class="clientId">
                ID: #<?= htmlspecialchars($client->getId()) ?>
            </div>
         </div>
      </div>

      <div class="midTicket">
        <div class="leftMidTicket">
            <div class="clientInformations">
                <p class="txt-secondary">Nom</p>
                <p><?= htmlspecialchars($client->getLname()) ?></p>
            </div>
            <div class="clientEmail">
                <p class="txt-secondary">Email</p>
                <p><?= htmlspecialchars($client->getEmail()) ?></p>
            </div>
        </div>
        <div class="rightMidTicket">
            <div class="clientPrenom">
                <p class="txt-secondary">Prénom</p>
                <p><?= htmlspecialchars($client->getFname()) ?></p>
            </div>
            <div class="clientPhone">
                <p class="txt-secondary">Téléphone</p>
                <p><?= htmlspecialchars($client->getPhone()) ?></p>
        </div>
      </div>
      <div class="bottomTicket">
        <!-- // to do : btn submit avec modif -->
      </div>

 

</div>


</body>
</html>
