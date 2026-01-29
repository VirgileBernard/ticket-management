<?php
require_once __DIR__ . '/../Controllers/TicketController.php';
session_start();

$_SESSION['flash-message delete'] = "Le ticket a été supprimé avec succès";

if (!isset($_POST['id_ticket'])) {
    die('ID ticket manquant');
}

$ticket_id = intval($_POST['id_ticket']);

TicketController::deleteTicket($ticket_id);

header('Location: ../views/tickets.php');
exit;
