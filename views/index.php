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
$tickets = TicketController::getTickets();
$totalTickets = TicketController::countTicketsByUser($userId);
$urgentTickets = TicketController::countUrgentTicketsByUser($userId);
$openTickets = TicketController::countOpenTicketsByUser($userId);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestion des Utilisateurs</title>
    <style>

  .topContainer{
        display: grid;
        grid-template-rows: 20% 80%;
        gap: 1rem;
        width: 100%;
        height: 25vh;
        margin-bottom: 10px;  /* à modif !!  */
        /* height: 25%; */
        border-bottom: 1px solid var(--LM-border);
    }
    .infoView{
        padding: 2rem 1rem;
    }

    .strong{
        font-weight: bold;
        font-size: .8rem;
    }

        .counterContainer{
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .counterCard{
        background-color: var(--LM-bg);
        border: 1px solid var(--LM-border);
        border-radius: var(--borderRadius);
        padding: 15px 10px;
        height: 100px;
        width: 100px;
        display: grid;
        grid-template-rows: 10% 90%;
        transition : all 0.3s ease-out;
        }

        .counterCard:hover{
            background-color: var(--LM-bg-light);
            box-shadow: var(--LM-box-shadow);
            /* cursor: pointer; */
        }

        .txtCounter{
            font-size: .7rem;
        }

        .counterTicket{
            display: flex;
            justify-content: center;
            align-items: center;
            font-size :  2.5rem;
        }

        .border-bottom{
            height: 1px;
            width: 100%;
            border-bottom: 1px solid var(--LM-border);
            margin-bottom: 3rem;
        }
    </style>
</head>
<body>

<div class="main">

    <?php
 include("navbar.php");
 ?>

    <div class="container">
<div class="topContainer">
    <div class="infoView">
        <p class="strong">Dashboard</p>
        <p>Bienvenue <?= htmlspecialchars($_SESSION['user_fname']) ?> <?= htmlspecialchars($_SESSION['user_lname']) ?></p>
    </div>
            <!-- <h1>Liste des Utilisateurs</h1> -->
      
<div class="counterContainer">
<div class="counterCard">
    <p class="txtCounter">Total tickets :</p>
    <p class="counterTicket"><?= $totalTickets ?></p>
</div>

<div class="counterCard">
    <p class="txtCounter">En cours :</p>
    <p class="counterTicket"><?= $openTickets ?></p>
</div>

<div class="counterCard">
    <p class="txtCounter">Urgent :</p>
    <p class="counterTicket"><?= $urgentTickets ?></p>
</div>

</div>

</div>


        
  <table class="user-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Appareil</th>
            <th>Statut</th>
            <th>Priorité</th>
            <th>Créé par</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket->getTicketNumber()) ?></td>
                <td><?= htmlspecialchars($ticket->client_name) ?></td>
                <td><?= htmlspecialchars($ticket->device_model) ?></td>
                <td><?= htmlspecialchars($ticket->status_name) ?></td>
                <td><?= htmlspecialchars($ticket->priority_name) ?></td>
                <td><?= htmlspecialchars($ticket->getCreatedBy( )) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>

    </div>
    <?php include("footer.php"); ?>
</body>
</html>