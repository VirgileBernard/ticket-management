<?php
require_once "config/MonPDO.php";

require_once __DIR__ . '/../Models/Ticket.php';




class TicketDAO {
 // obtenir tous les tickets (pour les tableaux)
public static function getTickets() { 
    $con = MONPDO::getPDO();

    $requete = "
        SELECT 
            t.id_ticket,
            t.ticket_number,
            t.client_id, 
            t.device_id,
            t.status_id,
            t.priority_id,
            t.created_by,
            CONCAT(c.fname, ' ', c.lname) AS client_name,
            CONCAT(u.fname, ' ', u.lname) AS creator_name,
            d.model AS device_model,
            s.nom AS status_name,
            p.nom AS priority_name
        FROM tickets t
        JOIN clients c ON t.client_id = c.id_client
        JOIN devices d ON t.device_id = d.id_device
        JOIN status s ON t.status_id = s.id_status
        JOIN priorities p ON t.priority_id = p.id_priority
        JOIN users u ON t.created_by = u.id_user
    ";

    $stmt = $con->prepare($requete); 
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    $tickets = [];

    foreach ($rows as $row) {
        $ticket = new Ticket(
            $row['id_ticket'], 
            $row['ticket_number'], 
            $row['client_id'],
            $row['device_id'],
            $row['status_id'],
            $row['priority_id'],
            $row['created_by']
        );

        // OPTIONNEL : stocker les noms pour l'affichage
        $ticket->client_name   = $row['client_name'];
        $ticket->device_model  = $row['device_model'];
        $ticket->status_name   = $row['status_name'];
        $ticket->priority_name = $row['priority_name'];
        $ticket->creator_name  = $row['creator_name'];

        $tickets[] = $ticket;
    }

    return $tickets; 
}


// obtenir un ticket par son numéro
    static function getTicket($ticket_number){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT * FROM tickets WHERE ticket_number = :ticket_number");
        $stmt->bindValue(":ticket_number", $ticket_number, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// créer un nouveau ticket
    static function createTicket($ticket){
         $con=MONPDO::getPDO();
        $stmt = $con->prepare("INSERT INTO tickets (ticket_number, client_id, device_id, status_id, priority_id, created_by) 
                              VALUES (:ticket_number, :client_id, :device_id, :status_id, :priority_id, :created_by)");
        
        $stmt->bindValue(":ticket_number",$ticket->getTicketNumber(),PDO::PARAM_STR);
        $stmt->bindValue(":client_id",$ticket->getClientId(),PDO::PARAM_INT);
        $stmt->bindValue(":device_id",$ticket->getDeviceId(),PDO::PARAM_INT);
        $stmt->bindValue(":status_id",$ticket->getStatusId(),PDO::PARAM_INT);
        $stmt->bindValue(":priority_id",$ticket->getPriorityId(),PDO::PARAM_INT);
        $stmt->bindValue(":created_by",$ticket->getCreatedBy(),PDO::PARAM_INT);
        
        $stmt->execute();
    }

    // ouvrir un ticket 
    static function openTicket($ticket_id){
        $con=MONPDO::getPDO();
       $requete = "
        SELECT 
            t.id_ticket,
            t.ticket_number,
            t.client_id, 
            t.device_id,
            t.status_id,
            t.priority_id,
            t.created_by,
            CONCAT(c.fname, ' ', c.lname) AS client_name,
            CONCAT(u.fname, ' ', u.lname) AS creator_name,
            d.model AS device_model,
            s.nom AS status_name,
            p.nom AS priority_name,
            MIN(i.start_at) AS intervention_start
        FROM tickets t
        JOIN clients c ON t.client_id = c.id_client
        JOIN devices d ON t.device_id = d.id_device
        JOIN status s ON t.status_id = s.id_status
        JOIN priorities p ON t.priority_id = p.id_priority
        JOIN users u ON t.created_by = u.id_user
        LEFT JOIN intervention i ON i.ticket_id = t.id_ticket
        WHERE t.id_ticket = :ticket_id
    ";
        $stmt = $con->prepare($requete);
        $stmt->bindValue(":ticket_id", $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows=$stmt->fetch(PDO::FETCH_ASSOC);

        $ticket= new Ticket(
            $rows['id_ticket'], 
            $rows['ticket_number'], 
            $rows['client_id'],
            $rows['device_id'],
            $rows['status_id'],
            $rows['priority_id'],
            $rows['created_by']
        );

        $ticket->client_name   = $rows['client_name'];
        $ticket->device_model  = $rows['device_model'];
        $ticket->status_name   = $rows['status_name'];
        $ticket->priority_name = $rows['priority_name'];
        $ticket->creator_name  = $rows['creator_name'];
        $ticket->intervention_start = $rows['intervention_start'];
        

        return $ticket;
    }
    

    //counter le nombre de tickets en cours par utilisateur
    static function countTicketsByUser($user_id){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT COUNT(*) as ticket_count FROM tickets WHERE created_by = :user_id");
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['ticket_count'];
    }

    //coubter le nombre de ticket terminé par utilisateur (COMPTEUR DANS LA NAVBAR)
    static function countDoneTicketsByUser($user_id){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT COUNT(*) as done_ticket_count FROM tickets WHERE created_by = :user_id AND status_id = 3");
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['done_ticket_count'];
    }

    //couter le nombre de ticket urgents par utilisateur
    static function countUrgentTicketsByUser($user_id){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT COUNT(*) as urgent_ticket_count FROM tickets WHERE created_by = :user_id AND priority_id = 4");
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['urgent_ticket_count'];
    }

    static function countOpenTicketsByUser($user_id){
        $con=MONPDO::getPDO();
        $stmt = $con->prepare("SELECT COUNT(*) as open_ticket_count FROM tickets WHERE created_by = :user_id AND status_id = 1");
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['open_ticket_count'];
    }


    //update un ticket
    public static function updateTicket($ticket) {
    $con = MONPDO::getPDO();
    $stmt = $con->prepare("
     UPDATE tickets
        SET 
            client_id = :client_id,
            device_id = :device_id,
            status_id = :status_id,
            priority_id = :priority_id
        WHERE id_ticket = :id_ticket");

    $stmt->bindValue(":client_id", $ticket->getClientId(), PDO::PARAM_INT);
    $stmt->bindValue(":device_id", $ticket->getDeviceId(), PDO::PARAM_INT);
    $stmt->bindValue(":status_id", $ticket->getStatusId(), PDO::PARAM_INT);
    $stmt->bindValue(":priority_id", $ticket->getPriorityId(), PDO::PARAM_INT);
    $stmt->bindValue(":id_ticket", $ticket->getIdTicket(), PDO::PARAM_INT);

    return $stmt->execute();
}

}