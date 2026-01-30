<?php

require_once __DIR__ . '/../DAO/ClientDAO.php';

class ClientController {

    public static function getClients() {
        return ClientDAO::getClients();
    }

    public static function openClient($client_id){
        return ClientDAO::openClient($client_id);
    }

    public static function updateClient($client){
        return ClientDAO::updateClient($client);
    }
    
    public static function deleteClient($client_id){
        return ClientDAO::deleteClient($client_id);
    }
    
    }