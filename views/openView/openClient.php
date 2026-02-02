<?php
require_once __DIR__ . '/../../Controllers/ClientController.php';
require_once __DIR__ . '/../../helpers/AccessControl.php';

session_start();

// Only supervisors can access this page
AccessControl::requireSupervisor();

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

<?php include __DIR__ . '/../navbar.php'; ?>
    <div class="container">
<div class="ticketInfo">

    <!-- TOP SECTION -->
    <div class="topTicket">
        <div class="leftTopTicket">
            <p>Informations du client</p>
        </div>
        <div class="rightTopTicket">
            <div class="clientId">
           <p>     ID: #<?= htmlspecialchars($client->getId()) ?></p>
            </div>
        </div>
    </div>

    <!-- MODE LECTURE -->
    <div id="clientView">

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
        </div>

        <div class="bottomTicket">
            <button id="editBtn" class="btn-primary">Modifier</button>
               <form action="../../process/deleteClient.php" method="POST">
    <input type="hidden" name="id_client" value="<?= $client->getId() ?>">
    <button
        type="submit"
        id="dangerBtn"
        onclick="return confirm('Supprimer définitivement ce client ?');"
    >Supprimer
    </button>
</form>
        </div>

    </div>


    <!-- MODE ÉDITION (caché au départ) -->
    <form id="editForm" action="../../process/updateClient.php" method="POST" style="display:none;">

        <input type="hidden" name="id_client" value="<?= $client->getId() ?>">

        <div class="midTicket">
            <div class="leftMidTicket">
                <div class="clientInformations">
                    <p class="txt-secondary">Nom</p>
                    <input type="text" name="lname" value="<?= htmlspecialchars($client->getLname()) ?>">
                </div>
                <div class="clientEmail">
                    <p class="txt-secondary">Email</p>
                    <input type="email" name="email" value="<?= htmlspecialchars($client->getEmail()) ?>">
                </div>
            </div>

            <div class="rightMidTicket">
                <div class="clientPrenom">
                    <p class="txt-secondary">Prénom</p>
                    <input type="text" name="fname" value="<?= htmlspecialchars($client->getFname()) ?>">
                </div>
                <div class="clientPhone">
                    <p class="txt-secondary">Téléphone</p>
                    <input type="text" name="phone_number" value="<?= htmlspecialchars($client->getPhone()) ?>">
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
const clientView = document.getElementById('clientView');
const cancelBtn = document.getElementById('cancelBtn');

editBtn.addEventListener('click', () => {
    clientView.style.display = 'none';
    editForm.style.display = 'block';
});

cancelBtn.addEventListener('click', () => {
    editForm.style.display = 'none';
    clientView.style.display = 'block';
});
</script>

</body>
</html>
