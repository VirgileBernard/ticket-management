<?php
require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/RoleController.php';


session_start();

$users = UserController::getUsers();
$roles = RoleController::getRoles();

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>



<div class="main">

<?php include __DIR__ . '/../navbar.php'; ?>

<div class="ticketInfo">

    <!-- TOP -->
    <div class="topTicket">
        <div class="leftTopTicket">
            <p>Créer un nouvel utilisateur</p>
            <?php var_dump($roles)?>
        </div>
    </div>


    <form action="../../process/createUser.php" method="POST" id="editForm">

    <div class="midTicket">
        <div class="leftMidTicket">

            <div class="userLname">
                <p class="txt-secondary">Nom de famille du membre</p>
                <input type="text" name="lname" placeholder="Nom de famille">
            </div>

                    <div class="userMail">
                <p class="txt-secondary">Mail du membre</p>
                <input type="text" name="email" placeholder="mail@bernitickets.be">
            </div>

                    <div class="userRole">
                <p class="txt-secondary">Role du membre</p>
                <select name="role_id">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role->getId() ?>">
                            <?= htmlspecialchars ($role->getName()) ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>
        </div>


    </div>


    </form>
    
</body>
</html>