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

}
