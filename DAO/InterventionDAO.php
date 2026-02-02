<?php
require_once "config/MonPDO.php";
require_once __DIR__ . "/../Models/Intervention.php";

// Toutes les opérations CRUD pour les interventions
class InterventionDAO{

    // Obtenir toutes les interventions
    public static function getInterventions(){
        $con = MONPDO::getPDO();
        $requete = "SELECT 
                    i.ticket_id,
                    i.user_id,
                    i.start_at,
                    i.end_at,
                    i.intervention_detail,
                    CONCAT(u.fname, ' ', u.lname) AS user_name,
                    t.ticket_number
                FROM intervention i
                JOIN users u ON i.user_id = u.id_user
                JOIN tickets t ON i.ticket_id = t.id_ticket";
        $stmt = $con->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les interventions d'un ticket
    public static function getInterventionsByTicket($ticket_id){
        $con = MONPDO::getPDO();
        $requete = "SELECT 
                    i.ticket_id,
                    i.user_id,
                    i.start_at,
                    i.end_at,
                    i.intervention_detail,
                    CONCAT(u.fname, ' ', u.lname) AS user_name
                FROM intervention i
                JOIN users u ON i.user_id = u.id_user
                WHERE i.ticket_id = :ticket_id
                ORDER BY i.start_at DESC";
        $stmt = $con->prepare($requete);
        $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les interventions d'un utilisateur
    public static function getInterventionsByUser($user_id){
        $con = MONPDO::getPDO();
        $requete = "SELECT 
                    i.ticket_id,
                    i.user_id,
                    i.start_at,
                    i.end_at,
                    i.intervention_detail,
                    t.ticket_number
                FROM intervention i
                JOIN tickets t ON i.ticket_id = t.id_ticket
                WHERE i.user_id = :user_id
                ORDER BY i.start_at DESC";
        $stmt = $con->prepare($requete);
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Créer une intervention
    public static function createIntervention($intervention){
        $con = MONPDO::getPDO();
        $requete = "INSERT INTO intervention 
                    (ticket_id, user_id, start_at, end_at, intervention_detail)
                    VALUES 
                    (:ticket_id, :user_id, :start_at, :end_at, :intervention_detail)";
        $stmt = $con->prepare($requete);

        $stmt->bindValue(":ticket_id", $intervention->getTicketId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $intervention->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(":start_at", $intervention->getStartAt(), PDO::PARAM_STR);
        $stmt->bindValue(":end_at", $intervention->getEndAt(), PDO::PARAM_STR);
        $stmt->bindValue(":intervention_detail", $intervention->getInterventionDetail(), PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            // If duplicate primary key (e.g., table uses ticket_id+user_id as PK),
            // append the new detail to the existing record instead of failing.
            if ($e->getCode() === '23000') {
                $upd = $con->prepare("UPDATE intervention SET end_at = :end_at, intervention_detail = CONCAT(COALESCE(intervention_detail,''), '\\n\\n', :intervention_detail) WHERE ticket_id = :ticket_id AND user_id = :user_id");
                $upd->bindValue(":end_at", $intervention->getEndAt(), PDO::PARAM_STR);
                $upd->bindValue(":intervention_detail", $intervention->getInterventionDetail(), PDO::PARAM_STR);
                $upd->bindValue(":ticket_id", $intervention->getTicketId(), PDO::PARAM_INT);
                $upd->bindValue(":user_id", $intervention->getUserId(), PDO::PARAM_INT);
                $upd->execute();
            } else {
                throw $e;
            }
        }
    }

    // Mettre à jour une intervention
    public static function updateIntervention($intervention){
        $con = MONPDO::getPDO();
        $requete = "UPDATE intervention
                    SET user_id = :user_id,
                        start_at = :start_at,
                        end_at = :end_at,
                        intervention_detail = :intervention_detail
                    WHERE ticket_id = :ticket_id";
        $stmt = $con->prepare($requete);

        $stmt->bindValue(":ticket_id", $intervention->getTicketId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $intervention->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(":start_at", $intervention->getStartAt(), PDO::PARAM_STR);
        $stmt->bindValue(":end_at", $intervention->getEndAt(), PDO::PARAM_STR);
        $stmt->bindValue(":intervention_detail", $intervention->getInterventionDetail(), PDO::PARAM_STR);

        $stmt->execute();
    }

    // Supprimer une intervention
    public static function deleteIntervention($ticket_id){
        $con = MONPDO::getPDO();
        $requete = "DELETE FROM intervention WHERE ticket_id = :ticket_id";
        $stmt = $con->prepare($requete);
        $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Vérifier si une intervention existe pour un ticket
    public static function interventionExists($ticket_id){
        $con = MONPDO::getPDO();
        $requete = "SELECT COUNT(*) as count FROM intervention WHERE ticket_id = :ticket_id";
        $stmt = $con->prepare($requete);
        $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
?>
