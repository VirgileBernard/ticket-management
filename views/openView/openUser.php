<?php

require_once __DIR__ . '/../../Controllers/UserController.php';
session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun user sélectionné.");
}

$user_id = intval($_GET['id']);
$user = UserController::openUser($user_id);
if(!$user) {
    die("Ce user n'existe pas.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipes </title>
        <link rel="stylesheet" href="../style.css">
</head>

<style>
    /* pour que le mdp de passe ne déborde pas */
    .userPass{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
     width: 150px;
    }
</style>
<body>
    
<div class="main">
    
<?php
 include __DIR__ . '/../navbar.php';
    ?>

<div class="ticketInfo">

    <div class="topTicket">
            <div class="leftTopTicket">
        <p>Informations du membre</p>
          </div>
            <div class="rightTopTicket">
        <div class="userId">
            ID: #<?= htmlspecialchars($user->getIdUser()) ?>
        </div>
    </div>
    </div>


    <div class="midTicket">
        <div class="leftMidTicket">
            <div class="userInformations">
                <p class="txt-secondary">Nom</p>
                <p><?= htmlspecialchars($user->getLname()) ?></p>
            </div>
            <div class="userEmail">
                <p class="txt-secondary">Email</p>
                <p><?= htmlspecialchars($user->getEmail()) ?></p>
            </div>
            <div class="userRole">
                <p class="txt-secondary">Rôle</p>
                <p><?= htmlspecialchars($user->getRoleId()) ?></p>
            </div>
        </div>
        <div class="rightMidTicket">
            <div class="userPrenom">
                <p class="txt-secondary">Prénom</p>
                <p><?= htmlspecialchars($user->getFname()) ?></p>
            </div>
          <div class="userPass">
                <p class="txt-secondary">Mot de passe</p>
                <p class="userPass"><?= htmlspecialchars($user->getPassword()) ?></p>
          </div>
          <div class="userTeam">
                <p class="txt-secondary">Équipe</p>
                <!-- <p><?= htmlspecialchars($user->getTeamId()) ?></p> -->
          </div>
     </div>

     <div class="bottomTicket">
        <!-- // to do : btn submit avec modif -->
     </div>

 </div>

</div>

</div>
</body>
</html>