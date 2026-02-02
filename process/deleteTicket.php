<?php
require_once __DIR__ . '/../Controllers/TicketController.php';
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../helpers/AccessControl.php';

session_start();

// Only supervisors can delete tickets
AccessControl::requireSupervisor();

$_SESSION['flash-message delete'] = "Le ticket a été supprimé";

if (!isset($_POST['id_ticket'])) {
    die('ID ticket manquant');
}

$ticket_id = intval($_POST['id_ticket']);

TicketController::deleteTicket($ticket_id);

header('Location: ../views/tickets.php');
exit;
