<?php

require_once __DIR__ . '/../Controllers/TicketController.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';

session_start();

// var_dump($_SESSION);
// exit;



$ticket_number = "TCK-" . "-" . rand(1, 100);

$ticket = new Ticket(
    null,
    $ticket_number,
    $_POST['client_id'],
    $_POST['device_id'],
    $_POST['status_id'],
    $_POST['priority_id'],
    $_POST['created_by']
);

$newId = TicketController::createTicket($ticket);

$_SESSION['flash_message_success'] = 'Ticket crée avec succès';

header("Location: " . BASE_URL . "views/tickets.php");
exit;