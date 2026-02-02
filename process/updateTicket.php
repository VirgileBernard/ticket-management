<?php

// var_dump($_POST);
// exit;

require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/../models/Intervention.php");
require_once(__DIR__ . "/../DAO/config/Baseurl.php");
require_once(__DIR__ . "/../Controllers/TicketController.php");
require_once(__DIR__ . "/../Controllers/InterventionController.php");

session_start();
// var_dump($_POST);
// exit;

// Ensure we have the ticket_number; if not provided, fetch existing ticket
$ticket_number = isset($_POST['ticket_number']) ? $_POST['ticket_number'] : null;
if (empty($ticket_number) && isset($_POST['id_ticket'])) {
    $existing = TicketController::openTicket(intval($_POST['id_ticket']));
    $ticket_number = $existing ? $existing->getTicketNumber() : null;
}

// Get the existing ticket to preserve created_by
$existing_ticket = TicketController::openTicket(intval($_POST['id_ticket']));
$created_by = $existing_ticket ? $existing_ticket->getCreatedBy() : null;

$ticket = new Ticket(
    $_POST['id_ticket'],
    $ticket_number,
    $_POST['client_id'],
    $_POST['device_id'],
    $_POST['status_id'],
    $_POST['priority_id'],
    $_POST['assigned_to'],
    $created_by
);

TicketController::updateTicket($ticket);

// Créer une intervention si un détail a été saisi
if (!empty($_POST['intervention_detail']) && trim($_POST['intervention_detail']) !== "") {
    $intervention = new Intervention(
        intval($_POST['id_ticket']),
        intval($_POST['user_id']),
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s'),
        trim($_POST['intervention_detail'])
    );
    InterventionController::createIntervention($intervention);
}

$_SESSION['flash-message edit'] = "Le ticket a été mis à jour avec succès.";

header("Location: " . BASE_URL . "views/tickets.php");
 exit;