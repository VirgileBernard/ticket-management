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
<body>
    
<div class="main">
    
<?php
 include __DIR__ . '/../navbar.php';
    ?>

<div class="container">
    <h1>Utilisateur ID: <?= htmlspecialchars($user->getIdUser()) ?></h1>

    <div class="user-details">
        <p><strong>Nom :</strong> <?= htmlspecialchars($user->getLname()) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user->getFname()) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user->getEmail()) ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($user->getPhone()) ?></p>
        <p><strong>Rôle ID :</strong> <?= htmlspecialchars($user->getRoleId()) ?></p>
    </div>
</div>

</div>
</body>
</html>