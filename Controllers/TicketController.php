<?php
require_once __DIR__ . '/../DAO/TicketDAO.php';

class TicketController {

    public static function getTickets() {
        return TicketDAO::getTickets();
    }

    // function to count done tickets by user
    public static function countDoneTicketsByUser($id){
        return TicketDAO::countDoneTicketsByUser($id);
    }
    
    //function to count tickets by user
    public static function countTicketsByUser($id){
        return TicketDAO::countTicketsByUser($id);
    }

    // function to ocunt urgent tickets by user
    public static function countUrgentTicketsByUser($id){
        return TicketDAO::countUrgentTicketsByUser($id);
    }

    //function to count open tickets by user
    public static function countOpenTicketsByUser($id){
        return TicketDAO::countOpenTicketsByUser($id);
    }

    public static function openTicket($ticket_id){
        return TicketDAO::openTicket($ticket_id);
    }

    public static function updateTicket($ticket) {
    return TicketDAO::updateTicket($ticket);
}

}
