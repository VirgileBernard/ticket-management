<?php
require_once __DIR__ . '/../DAO/TicketDAO.php';

class TicketController {

    public static function getTickets() {
        return TicketDAO::getTickets();
    }

    public static function countDoneTicketsByUser($id){
        return TicketDAO::countDoneTicketsByUser($id);
    }
}
