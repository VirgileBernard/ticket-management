<?php

require_once(__DIR__ . "/../Models/Intervention.php");
require_once(__DIR__ . "/../DAO/config/Baseurl.php");
require_once(__DIR__ . "/../Controllers/InterventionController.php");

session_start();

// Vérifier que tous les champs sont présents
if (!isset($_POST['ticket_id']) || !isset($_POST['user_id']) || !isset($_POST['intervention_detail'])) {
    $_SESSION['error'] = "Tous les champs sont obligatoires.";
    header("Location: " . BASE_URL . "views/tickets.php");
    exit;
}

$ticket_id = intval($_POST['ticket_id']);
$user_id = intval($_POST['user_id']);
$intervention_detail = trim($_POST['intervention_detail']);

// Vérifier que le détail n'est pas vide
if (empty($intervention_detail)) {
    $_SESSION['error'] = "Le détail de l'intervention ne peut pas être vide.";
    header("Location: " . BASE_URL . "views/openView/openTicket.php?id=" . $ticket_id);
    exit;
}

$start_at = date('Y-m-d H:i:s');
$end_at = date('Y-m-d H:i:s');

$intervention = new Intervention(
    $ticket_id,
    $user_id,
    $start_at,
    $end_at,
    $intervention_detail
);

try {
    InterventionController::createIntervention($intervention);
    $_SESSION['flash-message'] = "L'intervention a été ajoutée avec succès.";
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de l'ajout de l'intervention: " . $e->getMessage();
}

header("Location: " . BASE_URL . "views/openView/openTicket.php?id=" . $ticket_id);
exit;
?>
