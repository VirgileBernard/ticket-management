<?php
session_start();


// var_dump($_SESSION);
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../views/login.php');
    exit();
}

require_once ("../Controllers/userController.php");
require_once("../models/User.php");
$users = UserController::getUsers();



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
        <div class="topContainer">
    <div class="infoView">
        <p class="strong">Utilisateurs</p>
        <p>Voici l'ensemble de vos utilisateurs, <?= htmlspecialchars($_SESSION['user_fname']) ?> <?= htmlspecialchars($_SESSION['user_lname']) ?></p>
    </div>
</div>
        
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
                    <tr onclick="window.location='openView/openUser.php?id=<?= $user->getIdUser() ?>'">
                        <td><?= htmlspecialchars($user->getLname()); ?></td>
                        <td><?= htmlspecialchars($user->getFname()); ?></td>
                        <td><?= htmlspecialchars($user->getEmail()); ?></td>
                        <td><?= htmlspecialchars($user->getPhoneNumber()); ?></td>
                        <td><span class="badge"><?= htmlspecialchars($user->getRoleId()); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    </div>
    <?php include("footer.php"); ?>
         <?php if (isset($_SESSION['flash-message edit'])): ?>
    <div id="flash-message edit" class="flash-message edit">
        <?= $_SESSION['flash-message edit'] ?>
    </div>
    <?php unset($_SESSION['flash-message edit']); ?>
<?php endif; ?>
</body>
</html>