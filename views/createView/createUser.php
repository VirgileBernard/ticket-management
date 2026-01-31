<?php
require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/RoleController.php';


session_start();

$users = UserController::getUsers();
$roles = RoleController::getRoles();

?>


<!DOCTYPE html>
<html lang="en">
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
        </div>
    </div>


    <form action="../../process/createUser.php" method="POST" id="editForm">


    </form>
    
</body>
</html>