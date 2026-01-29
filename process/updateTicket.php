<?php

// var_dump($_POST);
// exit;

require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/../DAO/config/Baseurl.php");
require_once(__DIR__ . "/../Controllers/TicketController.php");

session_start();
$_SESSION['flash-message edit'] = "Le ticket a été mis à jour avec succès.";

$ticket = new Ticket(
    $_POST['id_ticket'],
    $_POST['ticket_number'],
    $_POST['client_id'],
    $_POST['device_id'],
    $_POST['status_id'],
    $_POST['priority_id'],
    $_POST['created_by']
);

TicketController::updateTicket($ticket);

header("Location: " . BASE_URL . "views/tickets.php");
 exit;