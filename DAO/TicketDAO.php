<?php
require_once "config/MonPDO.php";

require_once __DIR__ . '/../Models/Ticket.php';




class TicketDAO {
 // obtenir tous les tickets
  public static function getTickets() { $con = MONPDO::getPDO(); $sql = " SELECT t.id_ticket, t.ticket_number, CONCAT(c.fname, ' ', c.lname) AS client_name, d.model AS device_model, s.nom AS status, p.nom AS priority, t.created_by FROM tickets t JOIN clients c ON t.client_id = c.id_client JOIN devices d ON t.device_id = d.id_device JOIN status s ON t.status_id = s.id_status JOIN priorities p ON t.priority_id = p.id_priority "; $stmt = $con->prepare($sql); $stmt->execute(); $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); $tickets = []; foreach ($rows as $row) { $tickets[] = new Ticket( $row['id_ticket'], $row['ticket_number'], $row['client_name'], $row['device_model'], $row['status'], $row['priority'], $row['created_by'] ); } return $tickets; }

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
}