<?php
require_once __DIR__ . '/../DAO/InterventionDAO.php';
require_once __DIR__ . '/../Models/Intervention.php';

class InterventionController {

    // Obtenir toutes les interventions
    public static function getInterventions() {
        return InterventionDAO::getInterventions();
    }

    // Obtenir les interventions d'un ticket
    public static function getInterventionsByTicket($ticket_id) {
        return InterventionDAO::getInterventionsByTicket($ticket_id);
    }

    // Obtenir les interventions d'un utilisateur
    public static function getInterventionsByUser($user_id) {
        return InterventionDAO::getInterventionsByUser($user_id);
    }

    // Créer une intervention
    public static function createIntervention($intervention) {
        return InterventionDAO::createIntervention($intervention);
    }

    // Mettre à jour une intervention
    public static function updateIntervention($intervention) {
        return InterventionDAO::updateIntervention($intervention);
    }

    // Supprimer une intervention
    public static function deleteIntervention($ticket_id) {
        return InterventionDAO::deleteIntervention($ticket_id);
    }

    // Vérifier si une intervention existe
    public static function interventionExists($ticket_id) {
        return InterventionDAO::interventionExists($ticket_id);
    }

}
?>
