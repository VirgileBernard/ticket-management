<?php

require_once __DIR__ . '/../DAO/ClientDAO.php';

class ClientController {

    public static function getClients() {
        return ClientDAO::getClients();
    }
}