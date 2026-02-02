<?php

require_once __DIR__ . '/../Controllers/TicketController.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can create tickets
AccessControl::requireSupervisor();

$ticket_number = "TCK-" . "-" . rand(1, 100);

$ticket = new Ticket(
    null,
    $ticket_number,
    ($_POST['client_id']),
    ($_POST['device_id']),
    ($_POST['status_id']),
    ($_POST['priority_id']),
    ($_POST['assigned_to']),
    ($_SESSION['id_user'])
);

$newId = TicketController::createTicket($ticket);

$_SESSION['flash_message_success'] = 'Ticket crée avec succès';

header("Location: " . BASE_URL . "views/tickets.php");
exit;