<?php

// var_dump($_POST);
// exit;

require_once(__DIR__ . "/../models/Ticket.php");
require_once(__DIR__ . "/../models/Intervention.php");
require_once(__DIR__ . "/../DAO/config/Baseurl.php");
require_once(__DIR__ . "/../Controllers/TicketController.php");
require_once(__DIR__ . "/../Controllers/InterventionController.php");
require_once(__DIR__ . "/../helpers/AccessControl.php");

session_start();

// All roles can modify tickets (for adding interventions)
AccessControl::requireTicketModifyAccess();
// var_dump($_POST);
// exit;


$ticket = new Ticket(
    $_POST['id_ticket'],
    $ticket_number,
    intval($_POST['client_id']),
    intval($_POST['device_id']),
    intval($_POST['status_id']),
    intval($_POST['priority_id']),
    intval($_POST['assigned_to']),
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