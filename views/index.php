<?php
session_start();


// var_dump($_SESSION);
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
}

require_once ("../Controllers/userController.php");
require_once("../models/User.php");
require_once '../Controllers/TicketController.php';


$users = UserController::getUsers();
$userId = $_SESSION['id_user'];
// var_dump($_SESSION);

$totalTickets = TicketController::countTicketsByUser($userId);
$urgentTickets = TicketController::countUrgentTicketsByUser($userId);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestion des Utilisateurs</title>
</head>
<body>

<div class="main">

    <?php
 include("navbar.php");
 ?>

    <div class="container">
        <h1>Liste des Utilisateurs</h1>
        <p>Total de mes tickets : <?= $totalTickets ?></p>
<p>Tickets urgents : <?= $urgentTickets ?></p>

        
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->getLname()); ?></td>
                        <td><?= htmlspecialchars($user->getFname()); ?></td>
                        <td><?= htmlspecialchars($user->getEmail()); ?></td>
                        <td><?= htmlspecialchars($user->getPhone()); ?></td>
                        <td><span class="badge"><?= htmlspecialchars($user->getRoleId()); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    </div>
    <?php include("footer.php"); ?>
</body>
</html>